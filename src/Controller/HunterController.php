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

/**
 * Class HunterController
 *
 */
class HunterController
{


    /**
     * Retrieve hunter listing
     *
     * @return string
     */
    public function all()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $hunterManager = new HunterManager();
            $hunters = $hunterManager->selectAll();

            return json_encode($hunters);
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }

    /**
     * Retrieve hunter listing
     *
     * @return string
     */
    public function rankingAll()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data=[];
            $hunterManager = new HunterManager();
            $data['hunters'] = $hunterManager->selectAllByScore();

            $monsterManager = new MonsterManager();
            $data['monsters'] = $monsterManager->selectAllByScore();

            return json_encode($data);
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }


    /**
     * Retrieve hunter informations specified by $id
     *
     * @param int $id
     * @return string
     */
    public function show(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $hunterManager = new HunterManager();
            $hunter = $hunterManager->selectOneById($id);

            return json_encode($hunter);
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }


    /**
     * Edit hunter by $id
     *
     * @param int $id
     */
    public function edit(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            try {
                $hunterManager = new HunterManager();
                $hunter = $hunterManager->selectOneById($id);
                $json = file_get_contents('php://input');
                $obj = json_decode($json);
                $hunter['name'] = $obj->name;
                $hunter['description'] = $obj->description;
                $hunter['picture'] = $obj->picture;
                $hunter['level'] = $obj->level;
                $hunter['score'] = $obj->score;
                $hunterManager->update($hunter);
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
     * post new hunter
     *
     * @return string
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $json = file_get_contents('php://input');
                $obj = json_decode($json);
                $hunterManager = new HunterManager();
                $hunter = [
                    'name' => $obj->name,
                    'description' => $obj->description,
                    'picture' => $obj->picture,
                    'level' => $obj->level,
                    'score' => $obj->score,
                ];
                $id = $hunterManager->insert($hunter);
                header('HTTP/1.1 201 Created');
                return json_encode(['id' => $id]);
            } catch (\Exception $e) {
                /* var_dump should be delete in production */
                var_dump($e->getMessage());
                header('HTTP/1.1 500 Internal Server Error');
            }
        }
        header('HTTP/1.1 405 Method Not Allowed');
    }


    /**
     * Handle hunter deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            try {
                $hunterManager = new HunterManager();
                $hunterManager->delete($id);
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
