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
require_once CLASS_REALDIR . 'pages/mypage/LC_Page_Mypage_History.php';

/**
 * 購入履歴 のページクラス(拡張).
 *
 * LC_Page_Mypage_History をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Mypage_History_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Mypage_History_Ex extends LC_Page_Mypage_History {

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
     * Page のAction.
     *
     * @return void
     */
    function action() {
        parent::action();

        foreach ($this->tpl_arrOrderDetail as $key => $detail) {
            $this->lfSetOrderDetailData($detail);
            $this->tpl_arrOrderDetail[$key] = $detail;
        }

    }

    function lfSetOrderDetailData(&$detail) {
        $product_id = $detail['product_id'];
        $product_class_id = $detail['product_class_id'];

        $objProduct = new SC_Product_Ex();
        $objDb = new SC_Helper_DB_Ex();
        $productsClass = $objProduct->getProductsClass($product_class_id);
        $detail['productsClass'] = $productsClass;

        $class_name1 = $productsClass['class_name1'];
        $class_name2 = $productsClass['class_name2'];
        $detail['class_name1'] = (strpos($class_name1, '車種名') !== FALSE) ? '車種' : $class_name1;
        $detail['class_name2'] = (strpos($class_name2, '車種名') !== FALSE) ? '車種' : $class_name2;

        $detail['color1'] = $objDb->sfGetClassCatName($productsClass['classcategory_id1'], true);
        $detail['color2'] = $objDb->sfGetClassCatName($productsClass['classcategory_id2'], true);

        if (!SC_Utils_Ex::isBlank($detail['body_color_classcategory_id'])) {
            $detail['order_made_flg'] = true;
            $detail['body_color_name'] = $objDb->sfGetClassCatName($detail['body_color_classcategory_id']);
            $detail['back_color_name'] = $objDb->sfGetClassCatName($detail['back_color_classcategory_id']);
            $detail['edge_color_name'] = $objDb->sfGetClassCatName($detail['edge_color_classcategory_id']);
            $detail['edge_size_name'] = $objDb->sfGetClassCatName($detail['edge_size_classcategory_id']);
        } elseif (!SC_Utils_Ex::isBlank($detail['width_size'])) {
            $detail['JBstainplate_flg'] = true;
        }

        $detail['frill'] = $objDb->sfGetProductName($detail['frill_id']);
        $detail['unit'] = $objDb->sfGetUnit($product_id);
    }
}
