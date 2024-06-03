<?php

namespace Framework;

class Session
{
    /**
     * Start the session
     *
     * @return void
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set a status key/value pair
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value by key
     *
     * @param string $key
     * @param mixed $default
     * @return void
     */
    public static function get(string $key, mixed $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session key exists
     *
     * @param string $key
     * @return bool
     */
    public static function has(string $key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Clear session by key
     *
     * @param $Key
     * return void
     */
    public static function clear(string $Key)
    {
        if (isset($_SESSION[$Key])) {
            unset($_SESSION[$Key]);
        }
    }

    /**
     * Clear all session data
     *
     * @return void
     */
    public static function clearAll()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Set a flash message
     *
     * @param string $key
     * @param string $message
     * @return void
     */
    public static function setFlashMessage($key, $message)
    {
        self::set('flash_' . $key, $message);
    }

    /**
     * Get a flash message and unset
     *
     * @param string $key
     * @param mixed $default
     * @return string
     */
    public static function getFlashMessage($key, $default = null)
    {
        $message = self::get('flash_' . $key, $default);
        self::clear('flash_' . $key);
        return $message;
    }
}
