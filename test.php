<?php

use poker_model\Player;
use poker_model\Session;

require_once "server/controller/action.php";
require_once "server/model/DBO.php";
require_once "server/model/Player.php";
require_once "server/model/Session.php";


//clean();
//testCreateSession();
//testEnterSession();
//testStartRound();
//testCheckCallBetRaise();
testAllCheckOrCall();
//testHelpers();


function clean()
{
    Player::truncate();
    Session::truncate();
}

function testCreateSession()
{
    $result = createSession("Niklas", "Meine Session", 1000);
    dumbln(json_decode($result));
}

function testEnterSession()
{
    $result = enterSession("Simon", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("Jona", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("Leon", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("David", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("Mia", "asdf");
    dumbln(json_decode($result));

    $result = enterSession("Lina", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("Clara", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("Felix", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("Paul", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));

    $result = enterSession("Henri", "9v7qwa214opz7tguj9m6rhonypnc4sebeo8wxw4512isa8dtkx6wpeq1in7n1ujz");
    dumbln(json_decode($result));
}

function testStartRound()
{
    $result = startRound('6se5oui2kihcgpenpxn5fvssozoorsck4v0gtwds9wsntns8f5leutef7ykmgyfv');
    echo $result;
}

function testAllCheckOrCall()
{
    $result = checkOrCall('mco718iutl8gn776ufflioqnl0e3vhejw2sn4wrvdousbdqdd7mwfx0q85czaci2');
    println($result);
    $result = checkOrCall('hgvk6uk002z301ecmtzj9v1a0h57nn0n5cy5mi2c1r5y748ejion2kx1lshqop45');
    println($result);
    $result = checkOrCall('yus0936p4xbc9gpdmy28bp8e1sgez4qtsgbzewdj492pkauab06pjevkw17fn4t4');
    println($result);
    $result = checkOrCall('lx1jk7m0omiy3rood23cwnz6mv0qgzob55rav1almmelav8shbkigyiuhkqg9c5c');
    println($result);
    $result = checkOrCall('6gaj99hmj33on6f81k2qag0uoa675y3f8fgcc21jw6xjjo7hqjueoehsb9o00dmz');
    println($result);
    $result = checkOrCall('dn22binezhsvvcpyztjwme3b9p0ngc9slbp71nw3zyf1mv78e4sh923x83fwq44t');
    println($result);
    $result = checkOrCall('6se5oui2kihcgpenpxn5fvssozoorsck4v0gtwds9wsntns8f5leutef7ykmgyfv');
    println($result);

}

function testCheckCallBetRaise()
{
    $result = checkOrCall('mco718iutl8gn776ufflioqnl0e3vhejw2sn4wrvdousbdqdd7mwfx0q85czaci2');
    println($result);
    $result = betOrRaise('hgvk6uk002z301ecmtzj9v1a0h57nn0n5cy5mi2c1r5y748ejion2kx1lshqop45', 20);
    println($result);
    $result = checkOrCall('yus0936p4xbc9gpdmy28bp8e1sgez4qtsgbzewdj492pkauab06pjevkw17fn4t4');
    println($result);
    $result = betOrRaise('lx1jk7m0omiy3rood23cwnz6mv0qgzob55rav1almmelav8shbkigyiuhkqg9c5c', 60);
    println($result);
    $result = betOrRaise('6gaj99hmj33on6f81k2qag0uoa675y3f8fgcc21jw6xjjo7hqjueoehsb9o00dmz', 90);
    println($result);
    $result = checkOrCall('dn22binezhsvvcpyztjwme3b9p0ngc9slbp71nw3zyf1mv78e4sh923x83fwq44t');
    println($result);
    $result = checkOrCall('6se5oui2kihcgpenpxn5fvssozoorsck4v0gtwds9wsntns8f5leutef7ykmgyfv');
    println($result);
}

function testHelpers()
{
    $session = Session::getById(1);
    echo $session->areAllBetsEqual();
}


















































