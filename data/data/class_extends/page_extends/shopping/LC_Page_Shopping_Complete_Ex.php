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
require_once CLASS_REALDIR . 'pages/shopping/LC_Page_Shopping_Complete.php';

/**
 * ご注文完了 のページクラス(拡張).
 *
 * LC_Page_Shopping_Complete をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Shopping_Complete_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Shopping_Complete_Ex extends LC_Page_Shopping_Complete {

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
        $this->arrPref = $masterData->getMasterData('mtb_pref');
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
        $order_id = $_SESSION['order_id'];

        parent::action();

        //---Google Analyticsのeコマースサマリー対応ここから
        $this->lfSetGoogleAnalyticsData($order_id);
        //---ここまで---
    }

    function lfSetGoogleAnalyticsData($order_id) {
        $objPurchase = new SC_Helper_Purchase_Ex();
        $arrOrder = $objPurchase->getOrder($order_id);
        $arrOrderDetail = $objPurchase->getOrderDetail($order_id);
        $this->tax = $arrOrder['tax'];
        $this->deliv_fee = $arrOrder['deliv_fee'];
        $this->order_pref = $this->arrPref[$arrOrder['order_pref']];
        $this->orderId = $order_id;
        $this->total = $arrOrder['total']; // FIXME:payment_total じゃない？？？
        foreach($arrOrderDetail as $detail) {
            $this->arrProducts[] = array(
                'product_id' => $detail['product_id'],
                'product_name' => $detail['product_name'],
                'price' => $detail['price'],
                'quantity' => $detail['quantity'],
            );
        }
        $this->products_num = count($this->arrProducts);
    }

}
