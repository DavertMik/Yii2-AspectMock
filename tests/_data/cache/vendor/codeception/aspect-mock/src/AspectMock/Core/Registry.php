<?php
namespace AspectMock\Core;
use AspectMock\Kernel;

/**
 * Used to store tracked classes and objects.
 *
 * class Registry__AopProxied
 * @package AspectMock
 */
class Registry__AopProxied {

    protected static $classCalls = [];
    protected static $instanceCalls = [];
    protected static $returned = [];

    /**
     * @return Mock
     */
    protected static function getMockAspect()
    {
        return Kernel::getInstance()->getContainer()->getAspect('AspectMock\Core\Mocker');
    }

    static function registerClass($name, $params = array())
    {
        self::getMockAspect()->registerClass($name, $params);
    }

    static function registerObject($object, $params = array())
    {
        self::getMockAspect()->registerObject($object, $params);
    }

    static function getClassCallsFor($class)
    {
        return isset(self::$classCalls[$class])
            ? self::$classCalls[$class]
            : [];
    }

    static function getInstanceCallsFor($instance)
    {
        $oid = spl_object_hash($instance);
        return isset(self::$instanceCalls[$oid])
            ? self::$instanceCalls[$oid]
            : [];
    }


    static function clean()
    {
        self::getMockAspect()->clean();
        self::$classCalls = [];
        self::$instanceCalls = [];
    }

    static function registerInstanceCall($instance, $method, $args = array(), $returned = null)
    {
        $oid = spl_object_hash($instance);
        if (!isset(self::$instanceCalls[$oid])) self::$instanceCalls[$oid] = [];

        isset(self::$instanceCalls[$oid][$method])
            ? self::$instanceCalls[$oid][$method][] = $args
            : self::$instanceCalls[$oid][$method] = array($args);

        self::$returned["$oid->$method"] = $returned;
        
    }

    static function registerClassCall($class, $method, $args = array(), $returned = null)
    {
        if (!isset(self::$classCalls[$class])) self::$classCalls[$class] = [];

        isset(self::$classCalls[$class][$method])
            ? self::$classCalls[$class][$method][] = $args
            : self::$classCalls[$class][$method] = array($args);

        self::$returned["$class.$method"] = $returned;
    }



}/**
 * Used to store tracked classes and objects.
 *
 * Class Registry
 * @package AspectMock
 */
class Registry extends Registry__AopProxied implements \Go\Aop\Proxy
{


    /**
     *Property was created automatically, do not change it manually
     */
    private static $__joinPoints = array();
    
    
    public static function clean()
    {
        return self::$__joinPoints['static:clean']->__invoke(get_called_class());
    }
    
    
    public static function getClassCallsFor($class)
    {
        return self::$__joinPoints['static:getClassCallsFor']->__invoke(get_called_class(), array($class));
    }
    
    
    public static function getInstanceCallsFor($instance)
    {
        return self::$__joinPoints['static:getInstanceCallsFor']->__invoke(get_called_class(), array($instance));
    }
    
    /**
     * @return Mock
     */
    protected static function getMockAspect()
    {
        return self::$__joinPoints['static:getMockAspect']->__invoke(get_called_class());
    }
    
    
    public static function registerClass($name, $params = array())
    {
        return self::$__joinPoints['static:registerClass']->__invoke(get_called_class(), array($name, $params));
    }
    
    
    public static function registerClassCall($class, $method, $args = array(), $returned = null)
    {
        return self::$__joinPoints['static:registerClassCall']->__invoke(get_called_class(), array($class, $method, $args, $returned));
    }
    
    
    public static function registerInstanceCall($instance, $method, $args = array(), $returned = null)
    {
        return self::$__joinPoints['static:registerInstanceCall']->__invoke(get_called_class(), array($instance, $method, $args, $returned));
    }
    
    
    public static function registerObject($object, $params = array())
    {
        return self::$__joinPoints['static:registerObject']->__invoke(get_called_class(), array($object, $params));
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('AspectMock\Core\Registry', unserialize('a:8:{s:20:"static:getMockAspect";a:2:{i:0;C:40:"Go\\Aop\\Framework\\MethodAroundInterceptor":132:{a:1:{s:12:"adviceMethod";a:3:{s:5:"scope";s:6:"aspect";s:6:"method";s:11:"stubMethods";s:6:"aspect";s:22:"AspectMock\\Core\\Mocker";}}}i:1;C:40:"Go\\Aop\\Framework\\MethodAroundInterceptor":140:{a:1:{s:12:"adviceMethod";a:3:{s:5:"scope";s:6:"aspect";s:6:"method";s:19:"registerMethodCalls";s:6:"aspect";s:22:"AspectMock\\Core\\Mocker";}}}}s:20:"static:registerClass";a:2:{i:0;r:3;i:1;r:9;}s:21:"static:registerObject";a:2:{i:0;r:3;i:1;r:9;}s:23:"static:getClassCallsFor";a:2:{i:0;r:3;i:1;r:9;}s:26:"static:getInstanceCallsFor";a:2:{i:0;r:3;i:1;r:9;}s:12:"static:clean";a:2:{i:0;r:3;i:1;r:9;}s:27:"static:registerInstanceCall";a:2:{i:0;r:3;i:1;r:9;}s:24:"static:registerClassCall";a:2:{i:0;r:3;i:1;r:9;}}'));