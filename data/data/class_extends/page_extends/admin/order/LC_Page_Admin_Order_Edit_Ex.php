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
require_once CLASS_REALDIR . 'pages/admin/order/LC_Page_Admin_Order_Edit.php';

/**
 * 受注修正 のページクラス(拡張).
 *
 * LC_Page_Admin_Order_Edit をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Admin_Order_Edit_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Admin_Order_Edit_Ex extends LC_Page_Admin_Order_Edit {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->arrFrill = $this->lfGetSemiOption();
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

        $this->lfSetDetailDispData();
    }

    /**
     * パラメーター情報の初期化を行う.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @return void
     */
    function lfInitParam(&$objFormParam) {
        parent::lfInitParam($objFormParam);
        $objFormParam->overwriteParam('order_fax01', 'disp_name', 'ケータイ番号1');
        $objFormParam->overwriteParam('order_fax02', 'disp_name', 'ケータイ番号2');
        $objFormParam->overwriteParam('order_fax03', 'disp_name', 'ケータイ番号3');
        $objFormParam->overwriteParam('shipping_fax01', 'disp_name', 'ケータイ番号1');
        $objFormParam->overwriteParam('shipping_fax02', 'disp_name', 'ケータイ番号2');
        $objFormParam->overwriteParam('shipping_fax03', 'disp_name', 'ケータイ番号3');

        // その他
        $objFormParam->addParam('フレンジフリル', 'frill_id');
        $objFormParam->addParam("切り売りサイズ", "sell_piece_size", INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam("表の色ID", "body_color_classcategory_id");
        $objFormParam->addParam("裏の色ID", "back_color_classcategory_id");
        $objFormParam->addParam("フチの色ID", "edge_color_classcategory_id");
        $objFormParam->addParam("フチサイズID", "edge_size_classcategory_id");
        $objFormParam->addParam("表の色", "body_color_classcategory_name");
        $objFormParam->addParam("裏の色", "back_color_classcategory_name");
        $objFormParam->addParam("フチの色", "edge_color_classcategory_name");
        $objFormParam->addParam("フチサイズ", "edge_size_classcategory_name");
        $objFormParam->addParam("横サイズ", "width_size");
        $objFormParam->addParam("縦サイズ", "height_size");
    }

    /**
     * 受注データを取得して, SC_FormParam へ設定する.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @param integer $order_id 取得元の受注ID
     * @return void
     */
    function setOrderToFormParam(&$objFormParam, $order_id) {
        $objDb = new SC_Helper_DB_Ex();
        $objProduct = new SC_Product_Ex();
        $objPurchase = new SC_Helper_Purchase_Ex();

        // 受注詳細を設定
        $arrOrderDetail = $objPurchase->getOrderDetail($order_id, false);
        foreach ($arrOrderDetail as $key => $detail) {
            $productClass = $objProduct->getDetailAndProductsClass($detail['product_class_id']);
            if (!empty($detail['body_color_classcategory_id'])) {
                $arrOrderDetail[$key]['body_color_classcategory_name'] = $objDb->sfGetClassCatName($detail['body_color_classcategory_id']);
            }
            if (!empty($detail['back_color_classcategory_id'])) {
                $arrOrderDetail[$key]['back_color_classcategory_name'] = $objDb->sfGetClassCatName($detail['back_color_classcategory_id']);
            }
            if (!empty($detail['edge_color_classcategory_id'])) {
                $arrOrderDetail[$key]['edge_color_classcategory_name'] = $objDb->sfGetClassCatName($detail['edge_color_classcategory_id']);
            }
            if (!empty($detail['edge_size_classcategory_id'])) {
                $arrOrderDetail[$key]['edge_size_classcategory_name'] = $objDb->sfGetClassCatName($detail['edge_size_classcategory_id']);
            }
            if (!empty($detail['frill_id'])) {
                $arrOrderDetail[$key]['frill_name'] = $objDb->sfGetProductName($detail['frill_id']);
            }
        }
        $objFormParam->setParam(SC_Utils_Ex::sfSwapArray($arrOrderDetail));

        $arrShippingsTmp = $objPurchase->getShippings($order_id);
        $arrShippings = array();
        foreach ($arrShippingsTmp as $row) {
            // お届け日の処理
            if (!SC_Utils_Ex::isBlank($row['shipping_date'])) {
                $ts = strtotime($row['shipping_date']);
                $row['shipping_date_year'] = date('Y', $ts);
                $row['shipping_date_month'] = date('n', $ts);
                $row['shipping_date_day'] = date('j', $ts);
            }
            $arrShippings[$row['shipping_id']] = $row;
        }
        $objFormParam->setValue('shipping_quantity', count($arrShippings));
        $objFormParam->setParam(SC_Utils_Ex::sfSwapArray($arrShippings));

        /*
         * 配送商品を設定
         *
         * $arrShipmentItem['shipment_(key)'][$shipping_id][$item_index] = 値
         * $arrProductQuantity[$shipping_id] = お届け先ごとの配送商品数量
         */
        $arrProductQuantity = array();
        $arrShipmentItem = array();
        foreach ($arrShippings as $shipping_id => $arrShipping) {
            $arrProductQuantity[$shipping_id] = count($arrShipping['shipment_item']);
            foreach ($arrShipping['shipment_item'] as $item_index => $arrItem) {
                foreach ($arrItem as $item_key => $item_val) {
                    $arrShipmentItem['shipment_' . $item_key][$shipping_id][$item_index] = $item_val;
                }
            }
        }
        $objFormParam->setValue('shipping_product_quantity', $arrProductQuantity);
        $objFormParam->setParam($arrShipmentItem);

        /*
         * 受注情報を設定
         * $arrOrderDetail と項目が重複しており, $arrOrderDetail は連想配列の値
         * が渡ってくるため, $arrOrder で上書きする.
         */
        $arrOrder = $objPurchase->getOrder($order_id);
        $objFormParam->setParam($arrOrder);

        // ポイントを設定
        list($db_point, $rollback_point) = SC_Helper_DB_Ex::sfGetRollbackPoint(
            $order_id, $arrOrder['use_point'], $arrOrder['add_point'], $arrOrder['status']
        );
        $objFormParam->setValue('total_point', $db_point);
        $objFormParam->setValue('point', $rollback_point);

        if (!SC_Utils_Ex::isBlank($objFormParam->getValue('customer_id'))) {
            $arrCustomer = SC_Helper_Customer_Ex::sfGetCustomerDataFromId($objFormParam->getValue('customer_id'));
            $objFormParam->setValue('customer_point', $arrCustomer['point']);
        }
    }

    /**
     * DB更新処理
     *
     * @param integer $order_id 受注ID
     * @param SC_Helper_Purchase $objPurchase SC_Helper_Purchase インスタンス
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @param string $message 通知メッセージ
     * @param array $arrValuesBefore 更新前の受注情報
     * @return integer $order_id 受注ID
     *
     * エラー発生時は負数を返す。
     */
    function doRegister($order_id, &$objPurchase, &$objFormParam, &$message, &$arrValuesBefore) {
        //$order_id = parent::doRegister($order_id, $objPurchase, $objFormParam, $message, $arrValuesBefore);

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrValues = $objFormParam->getDbArray();

        $where = 'order_id = ?';

        $objQuery->begin();

        // 支払い方法が変更されたら、支払い方法名称も更新
        if ($arrValues['payment_id'] != $arrValuesBefore['payment_id']) {
            $arrValues['payment_method'] = $this->arrPayment[$arrValues['payment_id']];
            $arrValuesBefore['payment_id'] = NULL;
        }

        // 受注テーブルの更新
        $order_id = $objPurchase->registerOrder($order_id, $arrValues);

        $arrDetail = $objFormParam->getSwapArray(array(
                'product_id',
                'product_class_id',
                'product_code',
                'product_name',
                'price', 'quantity',
                'point_rate',
                'classcategory_name1',
                'classcategory_name2',
                'sell_piece_size',
                'body_color_classcategory_id',
                'back_color_classcategory_id',
                'edge_color_classcategory_id',
                'edge_size_classcategory_id',
                'width_size',
                'height_size',
                'frill_id',
        ));

        // 変更しようとしている商品情報とDBに登録してある商品情報を比較することで、更新すべき数量を計算
        $max = count($arrDetail);
        $k = 0;
        $arrStockData = array();
        for ($i = 0; $i < $max; $i++) {
            if (!empty($arrDetail[$i]['product_id'])) {
                $arrPreDetail = $objQuery->select('*', 'dtb_order_detail', 'order_id = ? AND product_class_id = ?', array($order_id, $arrDetail[$i]['product_class_id']));
                if (!empty($arrPreDetail) && $arrPreDetail[0]['quantity'] != $arrDetail[$i]['quantity']) {
                    // 数量が変更された商品
                    $arrStockData[$k]['product_class_id'] = $arrDetail[$i]['product_class_id'];
                    $arrStockData[$k]['quantity'] = $arrPreDetail[0]['quantity'] - $arrDetail[$i]['quantity'];
                    ++$k;
                } elseif (empty($arrPreDetail)) {
                    // 新しく追加された商品 もしくは 違う商品に変更された商品
                    $arrStockData[$k]['product_class_id'] = $arrDetail[$i]['product_class_id'];
                    $arrStockData[$k]['quantity'] = -$arrDetail[$i]['quantity'];
                    ++$k;
                }
                $objQuery->delete('dtb_order_detail', 'order_id = ? AND product_class_id = ?', array($order_id, $arrDetail[$i]['product_class_id']));
            }
        }

        // 上記の新しい商品のループでDELETEされなかった商品は、注文より削除された商品
        $arrPreDetail = $objQuery->select('*', 'dtb_order_detail', 'order_id = ?', array($order_id));
        foreach ($arrPreDetail AS $key=>$val) {
            $arrStockData[$k]['product_class_id'] = $val['product_class_id'];
            $arrStockData[$k]['quantity'] = $val['quantity'];
            ++$k;
        }

        // 受注詳細データの更新
        $objPurchase->registerOrderDetail($order_id, $arrDetail);

        // 在庫数調整
        if (ORDER_DELIV != $arrValues['status']
            && ORDER_CANCEL != $arrValues['status']) {
            foreach ($arrStockData AS $stock) {
                $objQuery->update('dtb_products_class', array(),
                                  'product_class_id = ?',
                                  array($stock['product_class_id']),
                                  array('stock' => 'stock + ?'),
                                  array($stock['quantity']));
            }
        }

        // ADD start
        // order_idをキーにpoint_id取得(0の場合は未登録)
        //$point_id = $this->lfGetPointID($arrValues['order_id']);
        $point_id = $this->lfGetPointID($order_id);

        // 発送済みにステータスが変わった場合は仮ポイントテーブルに登録
        if ($arrValues['status'] == ORDER_DELIV && $point_id == 0) {
            $this->lfRegistPoint($arrValues);
        // キャンセルにステータスが変わった場合は仮ポイントテーブルから削除
        } elseif ($arrValues['status'] == ORDER_CANCEL && $point_id != 0) {
            $this->lfDeletePoint($point_id);
        }
        // ADD end

        $arrAllShipping = $objFormParam->getSwapArray($this->arrShippingKeys);
        $arrAllShipmentItem = $objFormParam->getSwapArray($this->arrShipmentItemKeys);

        $arrDelivTime = $objPurchase->getDelivTime($objFormParam->getValue('deliv_id'));

        $arrShippingValues = array();
        foreach ($arrAllShipping as $shipping_index => $arrShipping) {
            $shipping_id = $arrShipping['shipping_id'];
            $arrShippingValues[$shipping_index] = $arrShipping;

            $arrShippingValues[$shipping_index]['shipping_date']
                = SC_Utils_Ex::sfGetTimestamp($arrShipping['shipping_date_year'],
                                              $arrShipping['shipping_date_month'],
                                              $arrShipping['shipping_date_day']);

            // 配送業者IDを取得
            $arrShippingValues[$shipping_index]['deliv_id'] = $objFormParam->getValue('deliv_id');

            // お届け時間名称を取得
            $arrShippingValues[$shipping_index]['shipping_time'] = $arrDelivTime[$arrShipping['time_id']];

            // 複数配送の場合は配送商品を登録
            if (!SC_Utils_Ex::isBlank($arrAllShipmentItem)) {
                $arrShipmentValues = array();

                foreach ($arrAllShipmentItem[$shipping_index] as $key => $arrItem) {
                    $i = 0;
                    if (!is_array($arrItem)) continue; // Warning回避
                    foreach ($arrItem as $item) {
                        $arrShipmentValues[$shipping_index][$i][str_replace('shipment_', '', $key)] = $item;
                        $i++;
                    }
                }
                $objPurchase->registerShipmentItem($order_id, $shipping_id,
                                                   $arrShipmentValues[$shipping_index]);
            }
        }
        $objPurchase->registerShipping($order_id, $arrShippingValues, false);
        $objQuery->commit();
        return $order_id;
    }

    /**
     * 受注商品の追加/更新を行う.
     *
     * 小画面で選択した受注商品をフォームに反映させる.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @return void
     */
    function doRegisterProduct(&$objFormParam) {
        //parent::doRegisterProduct($objFormParam);
        $product_class_id = $objFormParam->getValue('add_product_class_id');
        if (SC_Utils_Ex::isBlank($product_class_id)) {
            $product_class_id = $objFormParam->getValue('edit_product_class_id');
            $changed_no = $objFormParam->getValue('no');
        }
        // FXIME バリデーションを通さず $objFormParam の値で DB 問い合わせしている。(管理機能ため、さほど問題は無いと思うものの…)

        // 商品規格IDが指定されていない場合、例外エラーを発生
        if (strlen($product_class_id) === 0) {
            trigger_error('商品規格指定なし', E_USER_ERROR);
        }

        // 選択済みの商品であれば数量を1増やす
        $exists = false;
        $arrExistsProductClassIds = $objFormParam->getValue('product_class_id');
        // 商品の詳細設定により、表示欄を増やす必要があるため機能削除
        //foreach ($arrExistsProductClassIds as $key => $value) {
        //    $exists_product_class_id = $arrExistsProductClassIds[$key];
        //    if ($exists_product_class_id == $product_class_id) {
        //        $exists = true;
        //        $exists_no = $key;
        //        $arrExistsQuantity = $objFormParam->getValue('quantity');
        //        $arrExistsQuantity[$key]++;
        //        $objFormParam->setValue('quantity', $arrExistsQuantity);
        //    }
        //}

        // 新しく商品を追加した場合はフォームに登録
        // 商品を変更した場合は、該当行を変更
        if (!$exists) {
            $objProduct = new SC_Product_Ex();
            $arrProduct = $objProduct->getDetailAndProductsClass($product_class_id);

            // 一致する商品規格がない場合、例外エラーを発生
            if (empty($arrProduct)) {
                trigger_error('商品規格一致なし', E_USER_ERROR);
            }

            $arrProduct['quantity'] = 1;
            $arrProduct['price'] = $arrProduct['price02'];
            $arrProduct['product_name'] = $arrProduct['name'];

            $arrUpdateKeys = array(
                'product_id', 'product_class_id', 'product_type_id', 'point_rate',
                'product_code', 'product_name', 'classcategory_name1', 'classcategory_name2',
                'quantity', 'price',
            );
            foreach ($arrUpdateKeys as $key) {
                $arrValues = $objFormParam->getValue($key);
                // FIXME getValueで文字列が返る場合があるので配列であるかをチェック
                if (!is_array($arrValues)) {
                    $arrValues = array();
                }

                if (isset($changed_no)) {
                    $arrValues[$changed_no] = $arrProduct[$key];
                } else {
                    $added_no = 0;
                    if (is_array($arrExistsProductClassIds)) {
                        $added_no = count($arrExistsProductClassIds);
                    }
                    $arrValues[$added_no] = $arrProduct[$key];
                }
                $objFormParam->setValue($key, $arrValues);
            }
        } elseif (isset($changed_no) && $exists_no != $changed_no) {
            // 変更したが、選択済みの商品だった場合は、変更対象行を削除。
            $this->doDeleteProduct($changed_no, $objFormParam);
        }
    }

    function lfGetPointID($order_id) {
        $point_id = 0;

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'point_id';
        $table = 'dtb_point';
        $where = 'order_id = ?';
        $arrRet = $objQuery->select($col, $table, $where, array($order_id));

        if (!SC_Utils_Ex::isBlank($arrRet)) {
            foreach ($arrRet as $array) {
                //foreach($array as $key=>$val) {
                //    $point_id = $val;
                //}
                $point_id = $array['point_id'];
            }
        }

        return $point_id;
    }

    function lfRegistPoint($arrList) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objDb = new SC_Helper_DB_Ex();

        // INSERTする値を作成する。
        $sqlval['order_id'] = $arrList['order_id'];  
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';

        // 基本新規登録のみ
        if ($arrList['point_id'] == '') {
            // point_id 取得
            $point_id = $objQuery->nextVal('dtb_point_point_id');
            $sqlval['point_id'] = $point_id;

            // INSERTの実行
            $sqlval['create_date'] = 'CURRENT_TIMESTAMP';
            $objQuery->insert('dtb_point', $sqlval);
        // README:元々機能が消されていた
        //} else {
        //    $point_id = $arrList['point_id'];
        //    // 削除要求のあった既存ファイルの削除
        //    $arrRet = $this->lfGetProduct($arrList['point_id']);
        //    $this->objUpFile->deleteDBFile($arrRet);
        //
        //    // UPDATEの実行
        //    $where = "point_id = ?";
        //    $objQuery->update("dtb_point", $sqlval, $where, array($point_id));
        }
    }

    function lfDeletePoint($point_id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        // 登録するproductIDに登録されてるイベントIDを一度消去する
        $objQuery->delete('dtb_point', 'point_id = ?', array($point_id));
    }

    function lfSetDetailDispData() {
        $objDb = new SC_Helper_DB_Ex();
        $objProduct = new SC_Product_Ex();
        foreach ($this->arrForm['product_class_id']['value'] as $key => $id) {
            $product = $objProduct->getDetailAndProductsClass($id);
            $this->sell_piece_flg[$key] = $product['sell_piece_flg'];
            $this->order_made_flg[$key] = $product['order_made_flg'];
            $this->semi_order_made_flg[$key] = $product['semi_order_made_flg'];
            $this->back_color_flg[$key] = $product['back_color_class_id'];
            $this->JB_Stainplate_flg[$key] = ($product['class_name1'] == 'JBステンプレート') ? 1 : 0;
            $this->arrColor1[$key] = $objDb->sfGetClassCatName($product['classcategory_id1'], true);
            $this->arrColor2[$key] = $objDb->sfGetClassCatName($product['classcategory_id2'], true);
            $this->arrBodyCategory[$key] = $this->lfGetSelect($product['body_color_class_id']);
            $this->arrBackCategory[$key] = $this->lfGetSelect($product['back_color_class_id']);
            $this->arrEdgeCategory[$key] = $this->lfGetSelect($product['edge_color_class_id']);
            $this->arrSizeCategory[$key] = $this->lfGetSelect($product['edge_size_class_id']);
        }
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

    function lfGetSemiOption() {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrRet = array();

        // user_data/semi_option.php より
        $col = 'product_id, name';
        $table = 'dtb_products';
        $where = 'option_item_flg = ? AND del_flg = 0';
        $item_flg = 1;
        $arrProducts = $objQuery->select($col, $table, $where, array($item_flg));

        foreach ($arrProducts as $product) {
            $arrRet[$product['product_id']] = $product['name'];
        }

        return $arrRet;
    }
}
