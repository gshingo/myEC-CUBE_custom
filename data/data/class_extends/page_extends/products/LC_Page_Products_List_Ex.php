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
require_once CLASS_REALDIR . 'pages/products/LC_Page_Products_List.php';

/**
 * LC_Page_Products_List のページクラス(拡張).
 *
 * LC_Page_Products_List をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Products_List_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Products_List_Ex extends LC_Page_Products_List {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        if ($this->objDisplay->detectDevice() == DEVICE_TYPE_PC) {
            define('ITEMS_IN_ONEPAGE', 30);
        } else {
            define('ITEMS_IN_ONEPAGE', 10);
        }
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
     * Page のAction.
     *
     * @return void
     */
    function action() {
        if ($_REQUEST['name'] == 'キーワードを入力') $_REQUEST['name'] = null;

        parent::action();

        foreach ($this->arrProducts as $key => $product) {
            if ($key == 'productStatus') continue;
            if (empty($product['price01_min'])) {
                $this->arrPriceDown[$key] = 1;
            } else {
                $this->arrPriceDown[$key] = 0;
            }
        }

        // FIXME: 30 は 30件固定の影響。定数化すべき...?
        // FIXME: スマホは１ページ10件固定...
        // 表示件数始点
        $this->tpl_hitnum_start = ($this->objNavi->now_page - 1) * ITEMS_IN_ONEPAGE + 1;
        // 表示件数終点
        if ($this->objNavi->now_page == $this->objNavi->max_page) {
            $this->tpl_hitnum_end = $this->tpl_linemax;
        } elseif ($this->tpl_linemax <= ITEMS_IN_ONEPAGE) {
            $this->tpl_hitnum_end = $this->tpl_linemax;
        } else {
            $this->tpl_hitnum_end = $this->objNavi->now_page * ITEMS_IN_ONEPAGE;
        }

        $category_id = $this->lfGetCategoryId(intval($this->arrForm['category_id']));
        $this->lfSetSelectedCategoryFamily($category_id);
        $this->tpl_topicpath = SC_Helper_DB_Ex::sfGetTopicPath2($category_id);
        // FIXME:どこにも使ってないフラグ
        // 泥除けのカテゴリ内かチェック
        $this->tpl_doro_flg = false;
        if (SC_Helper_DB_Ex::sfGetTopicPath3($category_id, 31)) {
            $this->tpl_doro_flg = true;
        }
    }

    /**
     * パラメーターの読み込み
     *
     * @return void
     */
    function lfGetDisplayNum($display_number) {
        // 表示件数
        //return (SC_Utils_Ex::sfIsInt($display_number))
        //    ? $display_number
        //    : current(array_keys($this->arrPRODUCTLISTMAX));
        return ITEMS_IN_ONEPAGE; // 最大件数固定
    }

    /**
     * ページタイトルの設定
     *
     * @return str
     */
    function lfGetPageTitle($mode, $category_id = 0) {
        if ($mode == 'search') {
            return '検索結果';
        } elseif ($category_id == 0) {
            return '全商品';
        } else {
            $arrCat = SC_Helper_DB_Ex::sfGetCat($category_id);
            return $arrCat['name'];
            //return htmlentities($arrCat['name'], ENT_QUOTES, 'UTF-8');
        }
    }

    /* 商品一覧の表示 */
    function lfGetProductsList($searchCondition, $disp_number, $startno, $linemax, &$objProduct) {

        $arrOrderVal = array();

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        // 表示順序
        switch ($this->orderby) {
            // 販売価格が高い順
            case 'takai':
                $objProduct->setProductsOrder('price02', 'dtb_products_class', 'DESC');
                break;

            // 販売価格が安い順
            case 'price':
                $objProduct->setProductsOrder('price02', 'dtb_products_class', 'ASC');
                break;

            // 新着順
            case 'date':
                $objProduct->setProductsOrder('create_date', 'dtb_products', 'DESC');
                break;

            default:
                if (strlen($searchCondition['where_category']) >= 1) {
                    $dtb_product_categories = '(SELECT * FROM dtb_product_categories WHERE '.$searchCondition['where_category'].')';
                    $arrOrderVal           = $searchCondition['arrvalCategory'];
                } else {
                    $dtb_product_categories = 'dtb_product_categories';
                }
                $order = <<< __EOS__
                    (
                        SELECT
                            T3.rank * 2147483648 + T2.rank
                        FROM
                            $dtb_product_categories T2
                            JOIN dtb_category T3
                              ON T2.category_id = T3.category_id
                        WHERE T2.product_id = alldtl.product_id
                        ORDER BY T3.rank DESC, T2.rank DESC
                        LIMIT 1
                    ) DESC
                    ,product_id DESC
__EOS__;
                    $objQuery->setOrder($order);
                break;
        }
        // 取得範囲の指定(開始行番号、行数のセット)
        $objQuery->setLimitOffset($disp_number, $startno);
        $objQuery->setWhere($searchCondition['where']);

        // 表示すべきIDとそのIDの並び順を一気に取得
        $arrProductId = $objProduct->findProductIdsOrder($objQuery, array_merge($searchCondition['arrval'], $arrOrderVal));

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrProducts = $objProduct->getListByProductIds($objQuery, $arrProductId);

        // 規格を設定
        $objProduct->setProductsClassByProductIds($arrProductId);
        $arrProducts['productStatus'] = $objProduct->getProductStatus($arrProductId);
        return $arrProducts;
    }

    function lfSetSelectedCategoryFamily($category_id) {
        $objDb = new SC_Helper_DB_Ex();

        // 選択中のカテゴリの大カテゴリ取得
        $arr_cat_over_id = 0;
        $arr_cat_over_name = '';
        $arr_cat_same_tmp = $objDb->sfGetFirstCat($category_id);
        //$cnt = 0;
        //foreach ($arr_cat_same_tmp as $id) {
        //    if ($cnt == 0) {
        //        $arr_cat_over_id = $id;
        //    } elseif ($cnt == 1) {
        //        $arr_cat_over_name = $id;
        //    }
        //    $cnt++;
        //}
        $arr_cat_over_id = $arr_cat_same_tmp['id'];
        $arr_cat_over_name = $arr_cat_same_tmp['name'];

        // 選択中のカテゴリ同階層にあるカテゴリ取得
        $arr_cat_same_id = array();
        $arr_cat_same_name = array();
        $arr_cat_same_array = $objDb->sfGetCatUnderID($arr_cat_over_id);
        foreach ($arr_cat_same_array as $id) {
            $arr_cat_same_id[] = $id;
            $tmp_name = $objDb->sfGetCatName($id);
            $arr_cat_same_name[] = trim($tmp_name['name']);
        }

        // 選択中のカテゴリ直下にあるカテゴリ取得
        $arr_cat_under_id = $objDb->sfGetCatUnderID($category_id);
        $arr_cat_under_name = array();
        $arr_cat_under_num = count($arr_cat_under_id);

        //$cnt = 0;
        foreach ($arr_cat_under_id as $id) {
            $tmp_name = $objDb->sfGetCatName($id);
            $arr_cat_under_name[] = trim($tmp_name['name']);
        }

        $this->arr_cat_under_num = $arr_cat_under_num;
        $this->arr_cat_under_id = $arr_cat_under_id;
        $this->arr_cat_under_name = $arr_cat_under_name;
        $this->arr_now_cat_id = $category_id;
        $this->arr_cat_over_name = $arr_cat_over_name;
        $this->arr_cat_same_name = $arr_cat_same_name;
        $this->arr_cat_same_id = $arr_cat_same_id;
    }
}
