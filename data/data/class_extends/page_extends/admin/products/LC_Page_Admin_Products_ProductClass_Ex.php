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
require_once CLASS_REALDIR . 'pages/admin/products/LC_Page_Admin_Products_ProductClass.php';

/**
 * 商品登録(規格) のページクラス(拡張).
 *
 * LC_Page_Admin_Products_ProductClass をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id:LC_Page_Admin_Products_Product_Ex.php 15532 2007-08-31 14:39:46Z nanasess $
 */
class LC_Page_Admin_Products_ProductClass_Ex extends LC_Page_Admin_Products_ProductClass {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();

        $masterData = new SC_DB_MasterData_Ex();
        $this->arrPriceRank = $masterData->getMasterData('mtb_price_rank');
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {
        // 金華山生地の登録が重い為タイムアウト時間を延長(元は30秒)
        ini_set("max_execution_time",60);

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
     * パラメーター初期化
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @return void
     */
    function initParam(&$objFormParam) {
        parent::initParam($objFormParam);

        $objFormParam->addParam('価格ランク', 'price_rank1', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('色', 'color1', STEXT_LEN, 'KVa', array('SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
    }

    /**
     * 商品IDをキーにして, 商品規格の初期値を取得する.
     *
     * 商品IDをキーにし, デフォルトに設定されている商品規格を取得する.
     *
     * @param integer $product_id 商品ID
     * @return array 商品規格の配列
     */
    function getProductsClass($product_id) {
        $arrRet = parent::getProductsClass($product_id);

        //---------------UPDATE CODE @so001 START----------
        // 2012.12.26 暫定対処.
        //TODO 移行ミス？ classcategory_id1=0, classcategory_id2=0のdel_flg=1データがないため規格保存時に失敗してしまう.
        if (!is_array($arrRet)) $arrRet = array($arrRet); // Warning回避
/*
        if (!$arrRet) {
            $objQuery =& SC_Query_Ex::getSingletonInstance();
            $arrPC = $objQuery->select("*", "dtb_products_class", "product_id = ? AND del_flg = 0", array($product_id));
            $arrRet = $arrPC[0];
            $arrRet['classcategory_id1'] = '0';
            $arrRet['classcategory_id2'] = '0';
            $arrRet['del_flg'] = '1';
        }
*/
        //---------------UPDATE CODE @so001 E N D----------

        return $arrRet;
    }

    /**
     * 規格ID1, 規格ID2の規格分類すべてを取得する.
     *
     * @param integer $class_id1 規格ID1
     * @param integer $class_id2 規格ID2
     * @return array 規格と規格分類の配列
     */
    function getAllClassCategory($class_id1, $class_id2 = null) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        $col = <<< __EOF__
            T1.class_id AS class_id1,
            T1.classcategory_id AS classcategory_id1,
            T1.name AS classcategory_name1,
            T1.price_rank AS price_rank1,
            T1.color AS color1,
            T1.rank AS rank1
__EOF__;
        $table = '';
        $arrParams = array();
        if (SC_Utils_Ex::isBlank($class_id2)) {
            $col .= ',0 AS classcategory_id2';
            $table = 'dtb_classcategory T1 ';
            $objQuery->setWhere('T1.class_id = ?');
            $objQuery->setOrder('T1.rank DESC');
            $arrParams = array($class_id1);
        } else {
            $col .= <<< __EOF__
                ,
                T2.class_id AS class_id2,
                T2.classcategory_id AS classcategory_id2,
                T2.name AS classcategory_name2,
                T2.rank AS rank2
__EOF__;
            $table = 'dtb_classcategory AS T1, dtb_classcategory AS T2';
            $objQuery->setWhere('T1.class_id = ? AND T2.class_id = ?');
            $objQuery->setOrder('T1.rank DESC, T2.rank DESC');
            $arrParams = array($class_id1, $class_id2);
        }
        $arrClassCat = $objQuery->select($col, $table, '', $arrParams);

/*
        foreach ($arrClassCat as $class_cat_key => $class_cat) {
            if (!SC_Utils_Ex::isBlank($class_cat['price_rank1'])
                && !SC_Utils_Ex::isBlank($class_cat['color1'])
            ) {
                $classcategory_name1 = $class_cat['classcategory_name1'];
                $price_rank = $this->arrPriceRank[$class_cat['price_rank1']];
                $color = $class_cat['color1'];
                $classcategory_name1 = "{$classcategory_name1}\n{$price_rank}:{$color}";
                $arrClassCat[$class_cat_key]['classcategory_name1'] = $classcategory_name1;
            }
        }
*/

        return $arrClassCat;
    }

}
