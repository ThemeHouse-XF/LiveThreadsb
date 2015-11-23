<?php

class ThemeHouse_LiveThreads_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/LiveThreads/Extend/XenForo/ControllerPublic/Forum.php' => '3e6604db3284d88abaaf8ea188c02f34',
                'library/ThemeHouse/LiveThreads/Extend/XenForo/ControllerPublic/Thread.php' => 'df69e5f4167430c766cf04ce281400e7',
                'library/ThemeHouse/LiveThreads/Extend/XenForo/DataWriter/Discussion/Thread.php' => '9f571232a6c56faa846534f10f336430',
                'library/ThemeHouse/LiveThreads/Extend/XenForo/Model/Forum.php' => '63024fc46355d817612b957010ae5a39',
                'library/ThemeHouse/LiveThreads/Extend/XenForo/Model/Post.php' => 'c6de76692455402af0e1114c8d08656b',
                'library/ThemeHouse/LiveThreads/Extend/XenForo/Model/Thread.php' => 'cfbaf932b797d7a9caf4b3704cdf016a',
                'library/ThemeHouse/LiveThreads/Extend/XenForo/Model/ThreadWatch.php' => 'ec41fe00673bcfc6108c21af38ebaa0b',
                'library/ThemeHouse/LiveThreads/Install/Controller.php' => 'ba7df26954b1312fa19529514287477b',
                'library/ThemeHouse/LiveThreads/Listener/LoadClass.php' => '9b233d9568562d35d1292fe28f560b08',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
            ));
    }
}