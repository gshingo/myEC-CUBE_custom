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
require_once CLASS_REALDIR . 'pages/shopping/LC_Page_Shopping_Confirm.php';

/**
 * 入力内容確認 のページクラス(拡張).
 *
 * LC_Page_Shopping_Confirm をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Shopping_Confirm_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Shopping_Confirm_Ex extends LC_Page_Shopping_Confirm {

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
        //parent::action();

        $objCartSess = new SC_CartSession_Ex();
        $objSiteSess = new SC_SiteSession_Ex();
        $objCustomer = new SC_Customer_Ex();
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objPurchase = new SC_Helper_Purchase_Ex();
        $objHelperMail = new SC_Helper_Mail_Ex();
        $objHelperMail->setPage($this);

        $this->is_multiple = $objPurchase->isMultiple();

        // 前のページで正しく登録手続きが行われた記録があるか判定
        if (!$objSiteSess->isPrePage()) {
            SC_Utils_Ex::sfDispSiteError(PAGE_ERROR, $objSiteSess);
        }

        // ユーザユニークIDの取得と購入状態の正当性をチェック
        $this->tpl_uniqid = $objSiteSess->getUniqId();
        $objPurchase->verifyChangeCart($this->tpl_uniqid, $objCartSess);

        $this->cartKey = $objCartSess->getKey();

        // カート内商品のチェック
        $this->tpl_message = $objCartSess->checkProducts($this->cartKey);
        if (!SC_Utils_Ex::isBlank($this->tpl_message)) {

            SC_Response_Ex::sendRedirect(CART_URLPATH);
            SC_Response_Ex::actionExit();
        }

        // カートの商品を取得
        $this->arrShipping = $objPurchase->getShippingTemp($this->is_multiple);
        $this->arrCartItems = $objCartSess->getCartList($this->cartKey);
        // 合計金額
        $this->tpl_total_inctax[$this->cartKey] = $objCartSess->getAllProductsTotal($this->cartKey);
        // 税額
        $this->tpl_total_tax[$this->cartKey] = $objCartSess->getAllProductsTax($this->cartKey);
        // ポイント合計
        $this->tpl_total_point[$this->cartKey] = $objCartSess->getAllProductsPoint($this->cartKey);

        // 一時受注テーブルの読込
        $arrOrderTemp = $objPurchase->getOrderTemp($this->tpl_uniqid);

        // カート集計を元に最終計算
        $arrCalcResults = $objCartSess->calculate($this->cartKey, $objCustomer,
                                                  $arrOrderTemp['use_point'],
                                                  $objPurchase->getShippingPref($this->is_multiple),
                                                  $arrOrderTemp['charge'],
                                                  $arrOrderTemp['discount'],
                                                  $arrOrderTemp['deliv_id']);
        $this->arrForm = array_merge($arrOrderTemp, $arrCalcResults);

        // 会員ログインチェック
        if ($objCustomer->isLoginSuccess(true)) {
            $this->tpl_login = '1';
            $this->tpl_user_point = $objCustomer->getValue('point');
        }

        // 決済モジュールを使用するかどうか
        $this->use_module = $this->useModule($this->arrForm['payment_id']);

        switch ($this->getMode()) {
            // 前のページに戻る
            case 'return':
                // 正常な推移であることを記録しておく
                $objSiteSess->setRegistFlag();


                SC_Response_Ex::sendRedirect(SHOPPING_PAYMENT_URLPATH);
                SC_Response_Ex::actionExit();
                break;
            case 'confirm':
                /*
                 * 決済モジュールで必要なため, 受注番号を取得
                 */
                //$this->arrForm['order_id'] = $objQuery->nextval('dtb_order_order_id');
                $this->arrForm['order_id'] = $objQuery->nextVal('dtb_order_order_id'); // 正常に機能しているが、一応修正
                $_SESSION['order_id'] = $this->arrForm['order_id'];

                // 集計結果を受注一時テーブルに反映
                $objPurchase->saveOrderTemp($this->tpl_uniqid, $this->arrForm,
                                            $objCustomer);

                // 正常に登録されたことを記録しておく
                $objSiteSess->setRegistFlag();

                // 決済モジュールを使用する場合
                if ($this->use_module) {
                    $objPurchase->completeOrder(ORDER_PENDING);


                    SC_Response_Ex::sendRedirect(SHOPPING_MODULE_URLPATH);
                }
                // 購入完了ページ
                else {
                    $objPurchase->completeOrder(ORDER_NEW);
                    //$template_id = SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE ? 2 : 1;
                    $template_id = 1;
                    $objHelperMail->sfSendOrderMail(
                            $this->arrForm['order_id'],
                            $template_id);

                    SC_Response_Ex::sendRedirect(SHOPPING_COMPLETE_URLPATH);
                }
                SC_Response_Ex::actionExit();
                break;
            default:
                break;
        }

        // FIXME:カートに情報が入ってくるので、そっちを表示している.
        /*
        // 金華山生地の場合、色を取得
        $this->kinkazanColor1 = $this->lfGetKinkazanColor(1);
        $this->kinkazanColor2 = $this->lfGetKinkazanColor(2);

        // フレンジフリル情報取得
        $this->frill_name = $this->lfGetFrillName();
        */
    }

    function lfGetKinkazanColor($target) {
        $arrColor = array();

        $key = "classcategory_id{$target}";
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        foreach ($this->arrCartItems as $arr) {
            $key_id = $arr['productsClass'][$key];
            if ($key_id > 0) {
                if (array_key_exists($key_id, $this->arrFindColor)) {
                    $arrColor[] = $this->arrFindColor[$key_id];
                } else {
                    $where = "classcategory_id = ?";
                    $arrRet = $objQuery->select("color", "dtb_classcategory", $where, array($key_id));
                    if (isset($arrRet[0]['color'])) {
                        $set_color = $arrRet[0]['color'];
                    } else {
                        $set_color = '';
                    }
                    $this->arrFindColor[$key_id] = $set_color;
                    $arrColor[] = $set_color;
                }
            }
        }

        return $arrColor;
    }

    function lfGetFrillName() {
        $arrFrill = array();

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        foreach ($this->arrCartItems as $arr) {
            $key_id = $arr['semi_option_id'];
            if (isset($key_id) && $key_id > 0) {
                if (array_key_exists($key_id, $this->arrFindFrill)) {
                    $arrFrill[] = $this->arrFindFrill[$key_id];
                } else {
                    $where = 'product_id = ?';
                    $arrRet = $objQuery->select('name', 'dtb_products', $where, array($key_id));
                    if (isset($arrRet[0]['name'])) {
                        $set_frill = $arrRet[0]['name'];
                    } else {
                        $set_frill = '';
                    }
                    $this->arrFindFrill[$key_id] = $set_frill;
                    $arrFrill[] = $set_frill;
                }
            } else {
                $arrFrill[] = '';
            }
        }

        return $arrFrill;
    }

}
