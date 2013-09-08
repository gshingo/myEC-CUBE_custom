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
require_once CLASS_REALDIR . 'pages/admin/order/LC_Page_Admin_Order_ProductSelect.php';

/**
 * 商品選択 のページクラス(拡張).
 *
 * LC_Page_Admin_Order_ProductSelect をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Admin_Order_ProductSelect_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Admin_Order_ProductSelect_Ex extends LC_Page_Admin_Order_ProductSelect {

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

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action() {
        parent::action();

        $objDb = new SC_Helper_DB_Ex();
        if (!SC_Utils_Ex::isBlank($this->arrClassCat1)) {
            foreach ($this->arrClassCat1 as $product_id => $classCategory) {
                foreach ($classCategory as $classcategory_id => $name) {
                    if (SC_Utils_Ex::sfIsInt($classcategory_id)) {
                        $color = $objDb->sfGetClassCatName($classcategory_id, true);
                        if (SC_Utils_Ex::isBlank($color)) continue;
                        $this->arrClassCat1[$product_id][$classcategory_id] = "{$name}:{$color}";
                    }
                }
            }
        }
    }

    /**
     *
     * POSTされた値からSQLのWHEREとBINDを配列で返す。
     * @return array ('where' => where string, 'bind' => databind array)
     * @param SC_FormParam $objFormParam
     */
    function createWhere(&$objFormParam,&$objDb) {
        $arrRet = parent::createWhere($objFormParam, $objDb);

        $arrRet['where'] = 'alldtl.option_item_flg <> 1 AND ' . $arrRet['where'];

        return $arrRet;
    }

    /**
     * 規格クラス用JavaScript生成
     * @param SC_Product $objProduct
     */
    function getTplJavascript(&$objProduct) {
        $objDb = new SC_Helper_DB_Ex();
        foreach ($objProduct->classCategories as $product_id => $classCategories) {
            foreach ($classCategories as $classcategory_id1 => $classCategory) {
                $classcategory_id2 = $classCategory['classcategory_id2'];
                if (!SC_Utils_Ex::isBlank($classcategory_id2)) {
                    $color = $objDb->sfGetClassCatName($classcategory_id2, true);
                    if (SC_Utils_Ex::isBlank($color)) continue;
                    $objProduct->classCategories[$product_id][$classcategory_id1]['name'] .= ":{$color}";
                }
            }
        }
        return parent::getTplJavascript($objProduct);
    }

    /* セレクトボックスの作成 */
    function lfGetSelect($class_id) {
        if (!SC_Utils_Ex::sfIsInt($class_id)) return array();
        $arrRet = array();

        // 規格分類名一覧
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $keyname = 'classcategory_id';
        $valname = 'name';

        $table = 'dtb_classcategory';
        $col = "{$keyname}, {$valname}";
        $where = 'del_flg = 0 and class_id = ?';
        $objQuery->setOrder('rank DESC');
        $arrList = $objQuery->select($col, $table, $where, array($class_id));

        foreach ($arrList as $ret) {
            $arrRet[$ret[$keyname]] = $ret[$valname];
        }

        return $arrRet;
    }

}
