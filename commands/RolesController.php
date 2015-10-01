<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;

/**
 *
 */
class RolesController extends Controller
{
    /**
     *
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $rule = new \app\rbac\UserGroupRule;
        $auth->add($rule);

        $createRes = $auth->createPermission('createResource');
        $createRes->description = 'Create a resource';
        $auth->add($createRes);

        $updateRes = $auth->createPermission('updateResource');
        $updateRes->description = 'Update a resource';
        $auth->add($updateRes);

        $viewRes = $auth->createPermission('viewResource');
        $viewRes->description = 'View a resource';
        $auth->add($viewRes);

        $workRes = $auth->createPermission('workResource');
        $workRes->description = 'Work with a Resource';
        $auth->add($workRes);
        $auth->addChild($workRes, $viewRes);
        $auth->addChild($workRes, $createRes);
        $auth->addChild($workRes, $updateRes);

        $createMsg = $auth->createPermission('createTopic');
        $createMsg->description = 'Create a topic';
        $auth->add($createMsg);

        $updateMsg = $auth->createPermission('updateTopic');
        $updateMsg->description = 'Update topic';
        $auth->add($updateMsg);

        $hideMsg = $auth->createPermission('hideTopic');
        $hideMsg->description = 'Hide topic';
        $auth->add($hideMsg);

        $workMsg = $auth->createPermission('workTopic');
        $workMsg->description = 'Work with a Topic';
        $auth->add($workMsg);
        $auth->addChild($workMsg, $createMsg);
        $auth->addChild($workMsg, $updateMsg);
        $auth->addChild($workMsg, $hideMsg);

        $user = $auth->createRole('user');
        $user->ruleName = $rule->name;
        $auth->add($user);
        $auth->addChild($user, $createMsg);
        $auth->addChild($user, $updateMsg);
        echo "Create user\n";

        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $workRes);
        $auth->addChild($admin, $workMsg);
//        $auth->addChild($admin, $updateMsg);
//        $auth->addChild($admin, $user);
        echo "Create admin\n";
    }
}
