<?php
namespace controller\client_action\routing;

/**
 * Class PersonalRouter
 * This class is not in use yet
 * @package controller\client_action\routing
 *
 */
class PersonalRouter
{

    public static function find()
    {

        $nodes = explode('/', $_SERVER['REQUEST_URI']);
        $node = array_pop($nodes);
        $view = '..' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
        switch ($node) {
            case '':
                echo \view\Wrapper::header();

                echo \view\HomepageAND404::show('');

                echo \view\Wrapper::footer();
                break;
            case 'NDimArrays':
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::header();
                }
                require_once $view . 'NDimArrays.doc.php';
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::footer();
                }
                break;
            case 'IteratorClasses':
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::header();
                }
                require_once $view . 'IteratorClasses.doc.php';
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::footer();
                }
                break;
            case 'BoardFieldPiece':
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::header();
                }
                require_once $view . 'BoardFieldPiece.php';
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::footer();
                }
                break;
            case 'TestArea':
                require_once $view . 'DeleteMe.php';
                break;
            case 'PlayExample':
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::header();
                }
                require_once $view . 'play.php';
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::footer();
                }
                break;
            case explode('?', $node)[0] === 'Play':
                if (!isset($_POST['data']['next'])) {
                    echo \view\Wrapper::header();
                }
                require_once $view . 'playFromSelect.php';
                if (!isset($_POST['data']['next'])) {
                    echo \view\Wrapper::footer();
                }
                break;
            case 'board_select.js':
                require_once $view . 'board_select.js';
                break;
            case 'SelectBoard':
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::header();
                }
                require_once $view . 'database.php';
                if (!isset($_POST['data'])) {
                    echo \view\Wrapper::footer();
                }
                break;
            case 'SelectBoard.js':
                require_once 'SelectBoard.js';
                break;
            case 'ChessBoard.js':
                require_once 'ChessBoard.js';
                    break;
            case 'update':
                require_once $view . 'updateDatabase.php';
                break;
            case 'informMe':
                require_once $view . 'infromMe.php.';
                break;
            case 'narrenschach_animation.swf':
                require_once 'narrenschach_animation.swf';
                break;
            case 'videogames':
                echo \view\Wrapper::header();
                require_once $view . 'videogames.php';
                echo \view\Wrapper::footer();
            default:
                echo \view\Wrapper::header();
                echo \view\HomepageAND404::show($_SERVER['REQUEST_URI']);
                echo \view\Wrapper::footer();

        }

    }
}