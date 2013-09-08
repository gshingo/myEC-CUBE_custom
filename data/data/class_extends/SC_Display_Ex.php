<?php

require_once CLASS_REALDIR . 'SC_Display.php';

class SC_Display_Ex extends SC_Display{
    /**
     * デバイス毎の出力方法を自動で変更する、ファサード
     * Enter description here ...
     */
    function setDevice($device = DEVICE_TYPE_PC) {
        if (isset($_GET['pc_from_sphone']) && $_GET['pc_from_sphone'] == 0) {
            unset($_SESSION['pc_from_sphone']);
        } elseif (isset($_GET['pc_from_sphone']) && $_GET['pc_from_sphone'] == 1) {
            $_SESSION['pc_from_sphone'] = 1;
        }
        if ($_SESSION['pc_from_sphone'] == 1) $device = DEVICE_TYPE_PC;
        parent::setDevice($device);
    }

    /**
     * 端末種別を判別する。
     *
     * SC_Display::MOBILE = ガラケー = 1
     * SC_Display::SMARTPHONE = スマホ = 2
     * SC_Display::PC = PC = 10
     *
     * @static
     * @param   $reset  boolean
     * @return integer 端末種別ID
     */
    public static function detectDevice($reset = FALSE) {
        SC_Display_Ex::$device = parent::detectDevice($reset);
        if (isset($_GET['pc_from_sphone']) && $_GET['pc_from_sphone'] == 0) {
            unset($_SESSION['pc_from_sphone']);
        } elseif (isset($_GET['pc_from_sphone']) && $_GET['pc_from_sphone'] == 1) {
            $_SESSION['pc_from_sphone'] = 1;
        }
        if ($_SESSION['pc_from_sphone'] == 1) SC_Display_Ex::$device = DEVICE_TYPE_PC;
        return SC_Display_Ex::$device;
    }

}
