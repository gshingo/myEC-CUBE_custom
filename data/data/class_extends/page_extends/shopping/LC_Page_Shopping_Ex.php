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
require_once CLASS_REALDIR . 'pages/shopping/LC_Page_Shopping.php';

/**
 * ショッピングログイン のページクラス(拡張).
 *
 * LC_Page_Shopping をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Shopping_Ex.php 21867 2012-05-30 07:37:01Z nakanishi $
 */
class LC_Page_Shopping_Ex extends LC_Page_Shopping {

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
     * お客様情報入力時のパラメーター情報の初期化を行う.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @return void
     */
    function lfInitParam(&$objFormParam) {
        parent::lfInitParam($objFormParam);

        $objFormParam->overwriteParam('order_name01', 'disp_name', 'お名前（姓）');
        $objFormParam->overwriteParam('order_name02', 'disp_name', 'お名前（名）');
        $objFormParam->overwriteParam('order_kana01', 'disp_name', 'フリガナ（セイ）');
        $objFormParam->overwriteParam('order_kana02', 'disp_name', 'フリガナ（メイ）');
        $objFormParam->overwriteParam('order_fax01', 'disp_name', 'ケータイ番号1');
        $objFormParam->overwriteParam('order_fax02', 'disp_name', 'ケータイ番号2');
        $objFormParam->overwriteParam('order_fax03', 'disp_name', 'ケータイ番号3');
        $objFormParam->overwriteParam('shipping_name01', 'disp_name', 'お名前（姓）');
        $objFormParam->overwriteParam('shipping_name02', 'disp_name', 'お名前（名）');
        $objFormParam->overwriteParam('shipping_kana01', 'disp_name', 'フリガナ（セイ）');
        $objFormParam->overwriteParam('shipping_kana02', 'disp_name', 'フリガナ（メイ）');
    }

    /**
     * 入力内容のチェックを行う.
     *
     * 追加の必須チェック, 相関チェックを行うため, SC_CheckError を使用する.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @return array エラー情報の配
     */
    function lfCheckError(&$objFormParam) {
        // $arrErr = parent::lfCheckError($objFormParam);
        // 入力値の変換
        $objFormParam->convParam();
        $objFormParam->toLower('order_mail');
        $objFormParam->toLower('order_mail_check');

        $arrParams = $objFormParam->getHashArray();
        $objErr = new SC_CheckError_Ex($arrParams);
        $objErr->arrErr = $objFormParam->checkError();

        // 別のお届け先チェック
        if (isset($arrParams['deliv_check']) && $arrParams['deliv_check'] == '1') {
            //$objErr->doFunc(array('お名前(姓)', 'shipping_name01'), array('EXIST_CHECK'));
            //$objErr->doFunc(array('お名前(名)', 'shipping_name02'), array('EXIST_CHECK'));
            $objErr->doFunc(array('お名前（姓）', 'shipping_name01'), array('EXIST_CHECK'));
            $objErr->doFunc(array('お名前（名）', 'shipping_name02'), array('EXIST_CHECK'));
            //$objErr->doFunc(array('お名前(フリガナ・姓)', 'shipping_kana01'), array('EXIST_CHECK'));
            //$objErr->doFunc(array('お名前(フリガナ・名)', 'shipping_kana02'), array('EXIST_CHECK'));
            $objErr->doFunc(array('フリガナ（セイ）', 'shipping_kana01'), array('EXIST_CHECK'));
            $objErr->doFunc(array('フリガナ（メイ）', 'shipping_kana02'), array('EXIST_CHECK'));
            $objErr->doFunc(array('郵便番号1', 'shipping_zip01'), array('EXIST_CHECK'));
            $objErr->doFunc(array('郵便番号2', 'shipping_zip02'), array('EXIST_CHECK'));
            $objErr->doFunc(array('都道府県', 'shipping_pref'), array('EXIST_CHECK'));
            $objErr->doFunc(array('住所1', 'shipping_addr01'), array('EXIST_CHECK'));
            $objErr->doFunc(array('住所2', 'shipping_addr02'), array('EXIST_CHECK'));
            $objErr->doFunc(array('電話番号1', 'shipping_tel01'), array('EXIST_CHECK'));
            $objErr->doFunc(array('電話番号2', 'shipping_tel02'), array('EXIST_CHECK'));
            $objErr->doFunc(array('電話番号3', 'shipping_tel03'), array('EXIST_CHECK'));
        }

        // 複数項目チェック
        $objErr->doFunc(array('TEL', 'order_tel01', 'order_tel02', 'order_tel03'), array('TEL_CHECK'));
        //$objErr->doFunc(array('FAX', 'order_fax01', 'order_fax02', 'order_fax03'), array('TEL_CHECK'));
        $objErr->doFunc(array('ケータイ番号', 'order_fax01', 'order_fax02', 'order_fax03'), array('TEL_CHECK'));
        $objErr->doFunc(array('郵便番号', 'order_zip01', 'order_zip02'), array('ALL_EXIST_CHECK'));
        $objErr->doFunc(array('TEL', 'shipping_tel01', 'shipping_tel02', 'shipping_tel03'), array('TEL_CHECK'));
        $objErr->doFunc(array('郵便番号', 'shipping_zip01', 'shipping_zip02'), array('ALL_EXIST_CHECK'));
        $objErr->doFunc(array('生年月日', 'year', 'month', 'day'), array('CHECK_BIRTHDAY'));
        $objErr->doFunc(array('メールアドレス', 'メールアドレス（確認）', 'order_email', 'order_email02'), array('EQUAL_CHECK'));

        return $objErr->arrErr;
    }

    /**
     * 入力済みの購入情報をフォームに設定する.
     *
     * 受注一時テーブル, セッションの配送情報から入力済みの購入情報を取得し,
     * フォームに設定する.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @param SC_Helper_Purchase $objPurchase SC_Helper_Purchase インスタンス
     * @param integer $uniqid 購入一時情報のユニークID
     * @return void
     */
    function setFormParams(&$objFormParam, &$objPurchase, $uniqid) {
        //parent::setFormParams($objFormParam, $objPurchase, $uniqid);
        $arrOrderTemp = $objPurchase->getOrderTemp($uniqid);
        if (SC_Utils_Ex::isBlank($arrOrderTemp)) {
            $arrOrderTemp = array(
                'order_email' => '',
                'order_birth' => '',
            );
        }
        $arrShippingTemp = $objPurchase->getShippingTemp();

        $objFormParam->setParam($arrOrderTemp);
        /*
         * count($arrShippingTemp) > 1 は複数配送であり,
         * $arrShippingTemp[0] は注文者が格納されている
         */
        if (count($arrShippingTemp) > 1) {
            $objFormParam->setParam($arrShippingTemp[1]);
        } else {
            //$objFormParam->setParam($arrShippingTemp[0]);
            if (SC_Utils_Ex::isBlank($arrShippingTemp[0])
                && !SC_Utils_Ex::isBlank($arrShippingTemp[1])
            ) {
                $objFormParam->setParam($arrShippingTemp[1]);
            } else {
                $objFormParam->setParam($arrShippingTemp[0]);
            }
        }
        $objFormParam->setValue('order_email02', $arrOrderTemp['order_email']);
        $objFormParam->setDBDate($arrOrderTemp['order_birth']);
    }
}
