<?php

require_once '../vendor/autoload.php'; // Autoload our dependencies with Composer
require_once '../config/config.php'; // config APP

use Pragma\View\View;
use Pragma\Router\Router;

use App\Models\Player;
use App\Models\Game;

use App\Helpers\Redirect;
use App\Helpers\Security;

session_start();

/* Init global session structure */
if (empty($_SESSION['auth'])) {
	$_SESSION['auth'] = array(
		'userid'    => null,
		'username'  => null,
		'token'     => null
	);
}

if (!isset($_SESSION['view']['flash-messages'])) {
	$_SESSION['view']['flash-messages'] = array();
}

/* View configuration */
$view = View::getInstance();
$view->set_tpl_path(APP_PATH.'/Views/');
$view->setLayout('layout.tpl.php');
$view->initFlashStructure($_SESSION['view']['flash-messages']);

/* Global view variable */
if ($_SESSION['auth']['userid'] == null) {
	$view->assign('userid',     null);
	$view->assign('username',   null);
	$view->assign('usertoken',  null);
} else {
	$view->assign('userid',     $_SESSION['auth']['userid']);
	$view->assign('username',   $_SESSION['auth']['username']);
	$view->assign('usertoken',  $_SESSION['auth']['token']);
}

/* Get application router & start route definitions */
$app = Router::getInstance();

$app->get('/', function () use ($app) {
	//HOME PAGE
	View::getInstance()->assign('joinableGames', Game::getNonStartedGame());
	View::getInstance()->assign('router', $app);
	View::getInstance()->render('index.tpl.php');
})->alias('index');

$app->group('/login', function () use ($app) {
	$app->get('', function () use ($app) {
		$view = view::getinstance();

		$view->assign('form-action', $app->url_for('login-post'));

		$view->render('session/login-form.tpl.php');
	})->alias('login-form');
	$app->post('', function() use ($app) {
		$name   = filter_input(INPUT_POST, 'name',  FILTER_SANITIZE_STRING);
		$token  = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

		if ($name == null) {
			View::getInstance()->flash('User name empty', 'danger');
			Redirect::to($app->url_for('login-form'));
		}

		$player = Player::forge()->where('name', 'LIKE', $name)->first();

		if (!$player) {
			$player = new Player();
			$player->name = $name;

			$token = $player->token = Security::generateToken();
		}

		if (!Security::slowCompare($token, $player->token)) {
			View::getInstance()->flash('Password mismatch', 'danger');
			Redirect::to($app->url_for('index'));
		}

		$player->save();

		$_SESSION['auth']['userid']     = $player->id;
		$_SESSION['auth']['username']   = $player->name;
		$_SESSION['auth']['token']      = $player->token;

		View::getInstance()->flash('Successfully logged in', 'success');
		Redirect::to($app->url_for('index'));
	})->alias('login-post');
});

$app->group('/game', function () use ($app) {
	$app->post('', function () use ($app) {
		$game = new Game();
		$game->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

		$game->created = $game->updated = date('c');

		$game->save();

		Redirect::to($app->url_for('game-detail', ['gameid' => $game->id]));
	})->alias('game-creation');
	$app->get('/add', function ()  use ($app) {
		$view = View::getInstance();

		$game = new Game();

		$view->assign('game', $game);

		$view->assign('form-action', $app->url_for('game-creation'));
		$view->render('game/form.tpl.php');
	});
	$app->group('/:gameid', function () use ($app) {
		$app->get('', function ($gameId) use ($app) {
			$view = View::getInstance();

			$game = new Game();
			$game->open($gameId);

			$view->assign('game', $game);

			$view->assign('edit-link', $app->url_for('game-edit', ['gameid' => $game->id]));
			$view->assign('join-link', $app->url_for('game-join', ['gameid' => $game->id]));
			$view->assign('startgame-link', $app->url_for('game-start', ['gameid' => $game->id]));

			$view->render('game/detail.tpl.php');
		})->alias('game-detail');
		$app->get('/edit', function ($gameId) use ($app) {
			$view = View::getInstance();

			$game = new Game();
			$game->open($gameId);

			$view->assign('game', $game);

			$view->assign('form-action', $app->url_for('game-save', ['gameid' => $game->id]));
			$view->render('game/form.tpl.php');
		})->alias('game-edit');
		$app->post('', function ($gameId) use ($app) {
			$game = new Game();
			$game->open($gameId);

			$game->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

			$game->updated = date('c');

			$game->save();

			Redirect::to($app->url_for('game-detail', ['gameid' => $game->id]));
		})->alias('game-save');
		$app->get('/turn', function ($gameId) use ($app, $userId) {
			$game = new Game();
			$game->open($gameId);

			if ($game == null) {
				View::getInstance()->flash('Inexistent game', 'danger');
				Redirect::to($app->url_for('index'));
			}

			ob_clean();
			echo json_encode(['result' => $game->turn]);
			die();
		})->alias('game-turn');
		$app->get('/phase', function ($gameId) use ($app, $userId) {
			$game = new Game();
			$game->open($gameId);

			if ($game == null) {
				View::getInstance()->flash('Inexistent game', 'danger');
				Redirect::to($app->url_for('index'));
			}

			ob_clean();
			echo json_encode(['result' => $game->phase]);
			die();
		})->alias('game-phase');
		$app->group('', Security::requireAuthentication($app), function () use ($app) {
			// User is signed in, we can open the corresponding objet if necessary
			$userId = $_SESSION['auth']['userid'];

			$app->get('/join', function ($gameId) use ($app, $userId) {
				$game = new Game();
				$game->open($gameId);

				if ($game == null) {
					View::getInstance()->flash('Inexistent game', 'danger');
					Redirect::to($app->url_for('index'));
				}

				$player = new Player();
				$player->open($userId);

				if ($player == null) {
					View::getInstance()->flash('Inexistent player', 'danger');
					Redirect::to($app->url_for('index'));
				}

				if (!$game->isAttached($player) && !$game->addPlayer($player)) {
					View::getInstance()->flash('Can not join game', 'danger');
					Redirect::to($app->url_for('index'));
				}

				Redirect::to($app->url_for('game-dashboard', ['gameid' => $game->id]));
			})->alias('game-join');
			$app->get('/start', function ($gameId) use ($app, $userId) {
				$view = View::getInstance();

				$game = new Game();
				$game->open($gameId);

				if ($game == null) {
					View::getInstance()->flash('Inexistent game', 'danger');
					Redirect::to($app->url_for('index'));
				}

				$player = new Player();
				$player->open($userId);

				if ($player == null) {
					View::getInstance()->flash('Inexistent player', 'danger');
					Redirect::to($app->url_for('index'));
				}

				if ($game->started) {
					View::getInstance()->flash('Game is already started', 'danger');
					Redirect::to($app->url_for('index'));
				}

				if($game->isAttached($player) && $game->startGame()){
					View::getInstance()->flash('Game has started', 'success');
					Redirect::to($app->url_for('game-dashboard', ['gameid' => $game->id]));
				}

				View::getInstance()->flash('Cannot start game', 'danger');
				Redirect::to($app->url_for('game-detail',['gameid' => $game->id]));
			})->alias('game-start');
			$app->get('/dashboard', function ($gameId) use ($app, $userId) {
				$game = new Game();
				$game->open($gameId);

				if ($game == null) {
					View::getInstance()->flash('Inexistent game', 'danger');
					Redirect::to($app->url_for('index'));
				}

				$player = new Player();
				$player->open($userId);

				if ($player == null) {
					View::getInstance()->flash('Inexistent player', 'danger');
					Redirect::to($app->url_for('index'));
				}

				$view=View::getInstance();
				$view->assign('game', $game);
				$view->assign('player', $player);

				$view->assign('phase-link', $app->url_for('game-phase', ['gameid' => $game->id]));
				$view->assign('turn-link',  $app->url_for('game-turn', ['gameid' => $game->id]));

				$view->render('game/dashboard.tpl.php');

				// TODO: Main view - game data sum up - ajax refreshing - web stuff
			})->alias('game-dashboard');
			// $app->get('/secret', function ($gameId) use ($userId) {
			//     $game = new Game();
			//     $game->open($gameId);

			//     $player = new Player();
			//     $player->open($userId);

			//     var_dump($game);
			//     var_dump($player);
			// });
		});
	});
});

/* Start main loop - catch exception if any */
try {
	$app->run();
	$view->compute();
} catch (Pragma\Router\RouterException $e) {
	if ($e->getCode() == Pragma\Router\RouterException::NO_ROUTE_CODE) {
		Redirect::to($app->url_for('index'));
	}

	var_dump($e);
}
