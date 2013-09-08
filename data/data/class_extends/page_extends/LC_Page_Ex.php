<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once CLASS_REALDIR . 'pages/LC_Page.php';

class LC_Page_Ex extends LC_Page {
    /**
     * 互換性確保用メソッド
     *
     * @access protected
     * @return void
     * @deprecated 決済モジュール互換のため
     */
    function allowClientCache() {
        //$this->httpCacheControl('private');
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'Firefox') !== FALSE) {
            $this->httpCacheControl('private');
            //session_cache_limiter('private-no-expire');
        } else {
            $cache_expire = session_cache_expire() * 60;
            header("Pragma:");
            header("Expires:");
            header("Cache-Control: private, max-age={$cache_expire}, pre-check={$cache_expire}");
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        }
    }

}
