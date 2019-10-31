<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\FightManager;
use App\Model\HunterManager;
use App\Model\MonsterManager;

use \DateTime;

/**
 * Class FightController
 *
 */
class FightController
{


    /**
     * Retrieve fight listing
     *
     * @return string
     */
    public function all()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fightManager = new FightManager();
            $fights = $fightManager->selectAll();

            return json_encode($fights);
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }

    public function fightsByHunterId(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fightManager = new FightManager();
            $fights = $fightManager->selectAllByHunterId($id);
            return json_encode($fights);
        }
    }


    /**
     * Retrieve fight informations specified by $id
     *
     * @param int $id
     * @return string
     */
    public function show(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $fightManager = new FightManager();
            $fight = $fightManager->selectOneById($id);

            return json_encode($fight);
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }


    /**
     * Edit fight by $id
     *
     * @param int $id
     */
    public function edit(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            try {
                $fightManager = new FightManager();
                $fight = $fightManager->selectOneById($id);
                $json = file_get_contents('php://input');
                $obj = json_decode($json);
                $fight['title'] = $obj->title;
                $fightManager->update($fight);
                header('HTTP/1.1 204 resource updated successfully');
            } catch (\Exception $e) {
                /* var_dump should be delete in production */
                var_dump($e->getMessage());
                header('HTTP/1.1 500 Internal Server Error');
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
        }
    }


    /**
     * post new fight
     *
     * @return string
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $json = file_get_contents('php://input');
                $obj = json_decode($json);
                $fightManager = new FightManager();
                $fightDate = new DateTime();
                $date = $fightDate->format('Y-m-d H:i:s');
                $fight = [
                    'monster_id' => $obj->monster_id,
                    'hunter_id' => $obj->hunter_id,
                    'date' => $date,
                    'monster_points' => $obj->monster_points,
                    'hunter_points' => $obj->hunter_points,
                ];
                $fightManager->insert($fight);

                $monsterManager = new MonsterManager();
                $monster['monster_id'] = $obj->monster_id;
                $monster['monster_points'] = $obj->monster_points;
                $monsterManager->updateScore($monster);

                $hunterManager = new HunterManager();
                $hunter['hunter_id'] = $obj->hunter_id;
                $hunter['hunter_points'] = $obj->hunter_points;
                $hunterManager->updateScore($hunter);

                header('HTTP/1.1 201 Created');
            } catch (\Exception $e) {
                /* var_dump should be delete in production */
                var_dump($e->getMessage());
                header('HTTP/1.1 500 Internal Server Error');
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
        }
    }


    /**
     * Handle fight deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            try {
                $fightManager = new FightManager();
                $fightManager->delete($id);
                header('HTTP/1.1 204 resource deleted successfully');
            } catch (\Exception $e) {
                /* var_dump should be delete in production */
                var_dump($e->getMessage());
                header('HTTP/1.1 500 Internal Server Error');
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
        }
    }
}
