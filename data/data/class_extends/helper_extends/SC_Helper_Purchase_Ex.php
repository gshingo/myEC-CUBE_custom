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
require_once CLASS_REALDIR . 'helper/SC_Helper_Purchase.php';

/**
 * 商品購入関連のヘルパークラス(拡張).
 *
 * LC_Helper_Purchase をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Helper
 * @author Kentaro Ohkouchi
 * @version $Id: SC_Helper_Purchase_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class SC_Helper_Purchase_Ex extends SC_Helper_Purchase {
    /**
     * 配送情報をセッションから取得する.
     *
     * @param bool $has_shipment_item 配送商品を保有している配送先のみ返す。
     */
    function getShippingTemp($has_shipment_item = false) {
        $arrRet = parent::getShippingTemp($has_shipment_item);

        if (!is_array($arrRet)) $arrRet = array($arrRet); // Warning回避

        return $arrRet;
    }

    /**
     * 受注詳細を取得する.
     *
     * @param integer $order_id 受注ID
     * @param boolean $has_order_status 対応状況, 入金日も含める場合 true
     * @return array 受注詳細の配列
     */
    function getOrderDetail($order_id, $has_order_status = true) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $dbFactory  = SC_DB_DBFactory_Ex::getInstance();
        $col = <<< __EOS__
            T3.product_id,
            T3.product_class_id as product_class_id,
            T3.product_type_id AS product_type_id,
            T2.product_code,
            T2.product_name,
            T2.classcategory_name1 AS classcategory_name1,
            T2.classcategory_name2 AS classcategory_name2,
            T2.price,
            T2.quantity,
            T2.point_rate,
            T2.sell_piece_size,
            T2.body_color_classcategory_id,
            T2.back_color_classcategory_id,
            T2.edge_color_classcategory_id,
            T2.edge_size_classcategory_id,
            T2.width_size,
            T2.height_size,
            T2.frill_id,
__EOS__;
        if ($has_order_status) {
            $col .= 'T1.status AS status, T1.payment_date AS payment_date,';

        }
        $col .= <<< __EOS__
            CASE WHEN
                EXISTS(
                    SELECT * FROM dtb_products
                    WHERE product_id = T3.product_id
                        AND del_flg = 0
                        AND status = 1
                )
                THEN '1'
                ELSE '0'
            END AS enable,
__EOS__;
        $col .= $dbFactory->getDownloadableDaysWhereSql('T1') . ' AS effective';
        $from = <<< __EOS__
            dtb_order T1
            JOIN dtb_order_detail T2
                ON T1.order_id = T2.order_id
            LEFT JOIN dtb_products_class T3
                ON T2.product_class_id = T3.product_class_id
__EOS__;
        $objQuery->setOrder('T2.order_detail_id');
        return $objQuery->select($col, $from, 'T1.order_id = ?', array($order_id));
    }

    /**
     * お届け日一覧を取得する.
     */
    function getDelivDate(&$objCartSess, $productTypeId) {
        $cartList = $objCartSess->getCartList($productTypeId);
        $delivDateIds = array();
        foreach ($cartList as $item) {
            $delivDateIds[] = $item['productsClass']['deliv_date_id'];
        }
        $max_date = max($delivDateIds);
        //発送目安
        switch ($max_date) {
            //即日発送
            case '1':
                $start_day = 1;
                break;
                //1-2日後
            case '2':
                $start_day = 3;
                break;
                //3-4日後
            case '3':
                $start_day = 5;
                break;
                //1週間以内
            case '4':
                $start_day = 8;
                break;
                //2週間以内
            case '5':
                $start_day = 15;
                break;
                //3週間以内
            case '6':
                $start_day = 22;
                break;
                //1ヶ月以内
            case '7':
                $start_day = 32;
                break;
                //2ヶ月以降
            case '8':
                $start_day = 62;
                break;
                //お取り寄せ(商品入荷後)
            case '9':
                $start_day = '';
                break;
            default:
                //お届け日が設定されていない場合
                //$start_day = '';
                $start_day = '0';
                break;
        }
        //お届け可能日のスタート値から、お届け日の配列を取得する
        //$arrDelivDate = $this->getDateArray($start_day, DELIV_DATE_END_MAX);
        if ($start_day != '') {
            $arrDelivDate = $this->getDateArray($start_day, DELIV_DATE_END_MAX);
        }

        return $arrDelivDate;
    }

    /**
     * お届け可能日のスタート値から, お届け日の配列を取得する.
     */
    function getDateArray($start_day, $end_day) {
        $masterData = new SC_DB_MasterData_Ex();
        $arrWDAY = $masterData->getMasterData('mtb_wday');
        //お届け可能日のスタート値がセットされていれば
        //if ($start_day >= 1) {
        if ($start_day >= 0) {
            $now_time = time();
            $max_day = $start_day + $end_day;
            // 集計
            for ($i = $start_day; $i < $max_day; $i++) {
                // 基本時間から日数を追加していく
                $tmp_time = $now_time + ($i * 24 * 3600);
                list($y, $m, $d, $w) = explode(' ', date('Y m d w', $tmp_time));
                $val = sprintf('%04d/%02d/%02d(%s)', $y, $m, $d, $arrWDAY[$w]);
                $arrDate[$val] = $val;
            }
        } else {
            $arrDate = false;
        }
        return $arrDate;
    }

    /**
     * 受注登録を完了する.
     *
     * 引数の受注情報を受注テーブル及び受注詳細テーブルに登録する.
     * 登録後, 受注一時テーブルに削除フラグを立てる.
     *
     * @param array $orderParams 登録する受注情報の配列
     * @param SC_CartSession $objCartSession カート情報のインスタンス
     * @param integer $cartKey 登録を行うカート情報のキー
     * @param integer 受注ID
     */
    function registerOrderComplete($orderParams, &$objCartSession, $cartKey) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        // 不要な変数を unset
        $unsets = array('mailmaga_flg', 'deliv_check', 'point_check', 'password',
                        'reminder', 'reminder_answer', 'mail_flag', 'session');
        foreach ($unsets as $unset) {
            unset($orderParams[$unset]);
        }

        // 対応状況の指定が無い場合は新規受付
        if (SC_Utils_Ex::isBlank($orderParams['status'])) {
            $orderParams['status'] = ORDER_NEW;
        }

        $orderParams['create_date'] = 'CURRENT_TIMESTAMP';
        $orderParams['update_date'] = 'CURRENT_TIMESTAMP';

        $this->registerOrder($orderParams['order_id'], $orderParams);

        // 詳細情報を取得
        $cartItems = $objCartSession->getCartList($cartKey);

        // 詳細情報を生成
        $objProduct = new SC_Product_Ex();
        $i = 0;
        $arrDetail = array();
        foreach ($cartItems as $item) {
            $p =& $item['productsClass'];
            $arrDetail[$i]['order_id'] = $orderParams['order_id'];
            $arrDetail[$i]['product_id'] = $p['product_id'];
            $arrDetail[$i]['product_class_id'] = $p['product_class_id'];
            $arrDetail[$i]['product_name'] = $p['name'];
            $arrDetail[$i]['product_code'] = $p['product_code'];
            $arrDetail[$i]['classcategory_name1'] = $p['classcategory_name1'];
            $arrDetail[$i]['classcategory_name2'] = $p['classcategory_name2'];
            $arrDetail[$i]['point_rate'] = $item['point_rate'];
            $arrDetail[$i]['price'] = $item['price'];
            $arrDetail[$i]['quantity'] = $item['quantity'];
            $arrDetail[$i]['sell_piece_size'] = $item['sell_piece_size'];
            $arrDetail[$i]['body_color_classcategory_id'] = $item['body_color_classcategory_id'];
            $arrDetail[$i]['back_color_classcategory_id'] = $item['back_color_classcategory_id'];
            $arrDetail[$i]['edge_color_classcategory_id'] = $item['edge_color_classcategory_id'];
            $arrDetail[$i]['edge_size_classcategory_id'] = $item['edge_size_classcategory_id'];
            $arrDetail[$i]['width_size'] = $item['width_size'];
            $arrDetail[$i]['height_size'] = $item['height_size'];
            if (isset($item['semi_option_id']) && $item['semi_option_id'] > 0) {
                $arrDetail[$i]['frill_id'] = $item['semi_option_id'];
            }

            // 在庫の減少処理
            if (!$objProduct->reduceStock($p['product_class_id'], $item['quantity'])) {
                $objQuery->rollback();
                SC_Utils_Ex::sfDispSiteError(SOLD_OUT, '', true);
            }
            $i++;
        }
        $this->registerOrderDetail($orderParams['order_id'], $arrDetail);

        $objQuery->update('dtb_order_temp', array('del_flg' => 1),
                          'order_temp_id = ?',
                          array(SC_SiteSession_Ex::getUniqId()));



        return $orderParams['order_id'];
    }

    /**
     * 商品種別ID から配送業者を取得する.
     *
     * @param integer $product_type_id 商品種別ID
     * @return array 配送業者の配列
     */
    function getDeliv($product_type_id) {
        $arrDeliv = parent::getDeliv($product_type_id);

        // FIXME: 取得した配送先IDとカート内の商品情報から条件に合う支払い方法を選択し、支払い方法配列の有効なものだけを取得.
        //        LC_Page_Shopping_Payment_Ex 内からのみ実行されてほしい. (2.4系の配送方法選択なしの実現のため)
        if (is_a($this, 'SC_Helper_Purchase_Ex')) {
            $objCartSess = new SC_CartSession_Ex();
            $cart_key = $objCartSess->getKey();
            $arrTemp = $arrDeliv;
            $arrDeliv = array();
            foreach ($arrTemp as $key => $deliv) {
                $deliv_id = $deliv['deliv_id'];
                $total = $objCartSess->getAllProductsTotal($cart_key, $deliv_id);
                $arrPayment = $this->getPaymentsByPrice($total, $deliv_id);
                // 上限・下限の設定されていないものは除外
                foreach ($arrPayment as $pay_key => $payment) {
                    if (strlen($payment['rule_max']) == 0 && strlen($payment['upper_rule']) == 0) {
                        unset($arrPayment[$pay_key]);
                    } elseif (strlen($payment['rule_max']) > 0 && strlen($payment['upper_rule']) > 0
                        && $total < 10000 && $payment['upper_rule'] < 10000
                    ) {
                        // 通す
                    } elseif (strlen($payment['rule_max']) > 0 && strlen($payment['upper_rule']) > 0
                        && $total >= 10000 && $payment['rule_max'] >= 10000
                    ) {
                        // 通す
                    } else {
                        unset($arrPayment[$pay_key]);
                    }
                }
                if (!SC_Utils_Ex::isBlank($arrPayment)) {
                    $arrDeliv[] = $deliv;
                }
            }
        }

        return $arrDeliv;
    }

    function sendOrderMail($orderId) {
        $mailHelper = new SC_Helper_Mail_Ex();
        //---------------UPDATE CODE @so001 START----------
        //$template_id =
        //    SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE ? 2 : 1;
        $template_id = 1;
        //---------------UPDATE CODE @so001 E N D----------
        $mailHelper->sfSendOrderMail($orderId, $template_id);
    }

}
