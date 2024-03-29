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

// {{{ requires
require_once CLASS_REALDIR . 'pages/admin/design/LC_Page_Admin_Design_Header.php';

/**
 * ヘッダ, フッタ編集 のページクラス(拡張).
 *
 * LC_Page_Admin_Design_Header をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Admin_Design_Header_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Admin_Design_Header_Ex extends LC_Page_Admin_Design_Header {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {
        parent::process();
    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }

    function action() {
        parent::action();

        // 検索項目表示用
        $arrSearch = array();
        $objDb = new SC_Helper_DB_Ex();
        // 選択中のカテゴリIDを判定する
        $this->category_id = $objDb->sfGetCategoryId($_GET['product_id'], $_GET['category_id']);
        // カテゴリ検索用選択リスト
        $arrRet = $objDb->sfGetCategoryList('', true, '　');
        if(is_array($arrRet)) {
            // 文字サイズを制限する
            foreach($arrRet as $key => $val) {
                $str = SC_Utils_Ex::sfCutString($val, SEARCH_CATEGORY_LEN, false);
                $arrRet[$key] = preg_replace('/　/', "&nbsp;", $str);
            }
        }
        $this->arrCatList = $arrRet;
    }
}
