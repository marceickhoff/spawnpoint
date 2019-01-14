<?php
	abstract class Steam {
		const ini_file = 'spwn.ini';
		const ini_example_file = 'spwn.example.ini';

		private static $db;
		private static $config;

		private static function get_config() {
			if (empty(self::$config)) {
				if (!file_exists(self::ini_file)) {
					if (file_exists(self::ini_example_file)) copy(self::ini_example_file, self::ini_file);
					else trigger_error('ini file not found');
				}
				self::$config = parse_ini_file(self::ini_file);
			}
			return self::$config;
		}

		public static function is_member($steam_id) {
			foreach (self::get() as $members) {
				if ($members['steamid'] == $steam_id) return true;
			}
			return false;
		}

		public static function get($use_api = false) {
			self::$db = new PDO('sqlite:members.sqlite3');
			try {
				$result = self::$db->query('SELECT * FROM members ORDER BY id');
				$members = $result->fetchAll(PDO::FETCH_ASSOC);
				$steam_ids = array();
				foreach ($members as $key => $member) {
					if ($use_api) {
						$steam_api_recently_played = json_decode(file_get_contents('http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key='.self::get_config()['steam_api_key'].'&steamid='.$member['steamid'].'&count=1&format=json'), true);
						if (array_key_exists('games', $steam_api_recently_played['response'])) {
							$members[$key]['recentlyplayed'] = $steam_api_recently_played['response']['games'][0]['name'];
						}
						else {
							$members[$key]['recentlyplayed'] = null;
						}
					}
					if ($use_api and time() > $member['lastupdated'] + (self::get_config()['steam_most_played_update_interval'] * 60 * 60 * 24)) {
						$members[$key]['mostplayed'] = self::update_most_played($member['steamid']);
					}
					else $members[$key]['mostplayed'] = $member['mostplayed'];
					$now = new DateTime(date('Y-m-d'));
					$members[$key]['age'] = $now->diff(new DateTime($member['birthday']))->y;
					unset($members[$key]['birthday']);
					$steam_ids[] = $member['steamid'];
				}
				if ($use_api and count($steam_ids)) {
					$steam_api_players = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.self::get_config()['steam_api_key'].'&steamids='.implode(',', $steam_ids)), true);
					foreach ($steam_api_players['response']['players'] as $player) {
						foreach ($members as $key => $member) {
							if ($player['steamid'] == $member['steamid']) {
								//$members[$key]['currentlyplaying'] = $player['gameextrainfo'];
								$members[$key]['profileurl'] = $player['profileurl'];
								$avatar = 'content/img/avatars/'.$member['steamid'].'.jpg';
								if (!file_exists($avatar) || time() > filemtime($avatar) + (self::get_config()['steam_avatar_max_age'] * 60 * 60 * 24)) {
									$external = file_get_contents($player['avatarfull']);
									file_put_contents('content/img/avatars/'.$member['steamid'].'.jpg', $external);
								}
								$members[$key]['avatar'] = $avatar;
								break;
							}
						}
					}
				}
			}
			catch (PDOException $e) {
				$members = array();
			}
			return $members;
		}

		public static function update_most_played($steam_id) {
			$steam_api_games = json_decode(file_get_contents('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key='.self::get_config()['steam_api_key'].'&steamid='.$steam_id.'&format=json&include_appinfo=1'), true);
			$most_played = array(
				'playtime_forever' => 0
			);
			if (empty($steam_api_games['response'])) {
				$game_name_sql = 'NULL';
			}
			else {
				foreach ($steam_api_games['response']['games'] as $game) {
					if ($game['playtime_forever'] >= $most_played['playtime_forever']) {
						$most_played = $game;
					}
				}
				$game_name_sql = '"'.$most_played['name'].'"';
			}
			if (empty(self::$db)) {
				self::$db = new PDO('sqlite:members.sqlite3');
			}
			self::$db->query('UPDATE members SET mostplayed = '.$game_name_sql.', lastupdated = "'.(time() + substr($steam_id, strlen($steam_id - 4))).'" WHERE steamid = "'.$steam_id.'"');
			return $most_played['name'];
		}
	}
?>