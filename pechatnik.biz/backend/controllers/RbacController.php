<?php

namespace backend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rbac\DbManager;
use yii\rbac\Role;
use Yii;

class RbacController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
			'access' => [
					'class' => AccessControl::className(),
					'rules' => [
							[
									'allow' => true,
									'roles' => ['admin'],
							],
					],
					'denyCallback'  => function ($rule, $action) {
							Yii::$app->user->loginRequired();
					},
			],
		];
	}

    // public function actionInit()
    // {
    //     $authManager = Yii::$app->authManager;
		//
    //     // Create simple, based on action{$NAME} permissions
    //     $sell  = $authManager->createPermission('sell');
    //     $sell->description = 'Право на продажу товара';
    //     $authManager->add($sell);
		//
    //     $order = $authManager->createPermission('order');
    //     $sell->description = 'Право на продажу товара';
    //     $authManager->add($order);
		//
    //     $index  = $authManager->createPermission('index');
    //     $index->description = 'Право на просмотр страницы';
    //     $authManager->add($index);
		//
    //     $view   = $authManager->createPermission('view');
    //     $view->description = 'Право на просмотр страницы';
    //     $authManager->add($view);
		//
    //     $update = $authManager->createPermission('update');
    //     $update->description = 'Право на просмотр страницы';
    //     $authManager->add($update);
		//
    //     $delete = $authManager->createPermission('delete');
    //     $delete->description = 'Право на просмотр страницы';
    //     $authManager->add($delete);
    // }

		// public function actionUp()
    // {
    //     $auth = Yii::$app->authManager;
		//
    //     // $manageArticles = $auth->createPermission('manageArticles');
    //     // $manageArticles->description = 'Manage articles';
    //     // $auth->add($manageArticles);
		// 		//
    //     // $manageUsers = $auth->createPermission('manageUsers');
    //     // $manageUsers->description = 'Manage users';
    //     // $auth->add($manageUsers);
		//
    //     $user = $auth->createRole('user');
    //     $user->description = 'User';
    //     $auth->add($user);
    //     // $auth->addChild($moderator, $manageArticles);
		//
    //     $admin = $auth->createRole('admin');
    //     $admin->description = 'Administrator';
    //     $auth->add($admin);
    //     // $auth->addChild($admin, $moderator);
    //     // $auth->addChild($admin, $manageUsers);
    // }

    public function actionIndex()
    {
        return $this->render('index', ['roles' => Yii::$app->authManager->getRoles()]);
    }

    public function actionCreate()
    {
        $auth = Yii::$app->authManager;

        foreach ($auth->getRoles() as $value) {
            $roles[$value->name] = $value->description;
        }

        if(Yii::$app->request->isPost){
            $role = $auth->createRole($_POST['role']);
		    		$role->description = $_POST['desc'];
		    		$auth->add($role);
		            $auth->removeChildren($auth->getRole($role));
		            foreach ($_POST['child'] as $value) {
		                $auth->addChild($auth->getRole($role), $auth->getRole($value));
		            }
		    		return $this->redirect(['rbac/index']);
		    	}

        return $this->renderAjax('_modal', [
            'role'=>'',
            'roles'=>$roles,
            'children'=>'',
        ]);
    }

    public function actionUpdate($id)
    {
        $children =  [];
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole($id);

        foreach ($auth->getRoles() as $value) {
            if ($value->name !== $role && $value->name !== 'admin')
            $roles[$value->name] = $value->description;
        }

        foreach ($auth->getChildren($id) as $v) {
            $children[] = $v->name;
        }

        foreach ($auth->getPermissions() as $p) {
            $perm[$p->name] = $p->description;
        }

    	if(Yii::$app->request->isPost){
    		$role->name = $_POST['role'];
    		$role->description = $_POST['desc'];
    		$auth->update($id, $role);
            $auth->removeChildren($auth->getRole($id));

            if(isset($_POST['child'])){
                foreach ($_POST['child'] as $value) {
                    $auth->addChild($auth->getRole($id), $auth->getRole($value));
                }
            }

    		return $this->redirect(['rbac/index']);
    	}

        return $this->renderAjax('_modal', [
            'role'=>$id,
            'roles'=>$roles,
            'children'=>$children,
        ]);
    }

    public function actionDelete($id)
    {
    	if(Yii::$app->request->isPost){
	    	$auth = \Yii::$app->authManager;
	    	$role = $auth->getRole($id);
	    	$auth->remove($role);
	    	return $this->redirect(['index']);
	    }
    }

    public function actionRel($role)
    {
    	if(Yii::$app->request->isPost){
    		$auth = \Yii::$app->authManager;
    		$auth->removeChildren($auth->getRole($role));
    		foreach ($_POST['child'] as $value) {
    			$auth->addChild($auth->getRole($role), $auth->getRole($value));
    		}
    		return $this->redirect(['rbac/update','id'=>$role]);

            $roles =  [];
            foreach (\Yii::$app->authManager->getRoles() as $value) {
                if ($value->name !== $role && $value->name !== 'admin')
                $roles[$value->name] = $value->description;
            }

            foreach (\Yii::$app->authManager->getChildren($role->id) as $v) {
                $children[] = $v->name;
            }
    	}
    }

}
