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
require_once CLASS_REALDIR . 'helper/SC_Helper_Customer.php';

/**
 * CSV関連のヘルパークラス(拡張).
 *
 * LC_Helper_Customer をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Helper
 * @author LOCKON CO.,LTD.
 * @version $Id:SC_Helper_DB_Ex.php 15532 2007-08-31 14:39:46Z nanasess $
 */
class SC_Helper_Customer_Ex extends SC_Helper_Customer {
    /**
     * 会員共通
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @access public
     * @return void
     */
    function sfCustomerCommonParam(&$objFormParam) {
        parent::sfCustomerCommonParam($objFormParam);
        $objFormParam->overwriteParam('name01', 'disp_name', 'お名前（姓）');
        $objFormParam->overwriteParam('name02', 'disp_name', 'お名前（名）');
        $objFormParam->overwriteParam('kana01', 'disp_name', 'フリガナ（セイ）');
        $objFormParam->overwriteParam('kana02', 'disp_name', 'フリガナ（メイ）');
        $objFormParam->overwriteParam('addr01', 'disp_name', 'ご住所1');
        $objFormParam->overwriteParam('addr02', 'disp_name', 'ご住所2');
        $objFormParam->overwriteParam('fax01', 'disp_name', 'ケータイ番号1');
        $objFormParam->overwriteParam('fax02', 'disp_name', 'ケータイ番号2');
        $objFormParam->overwriteParam('fax03', 'disp_name', 'ケータイ番号3');
    }

    /**
     * 会員登録共通
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @param boolean $isAdmin true:管理者画面 false:会員向け
     * @param boolean $is_mypage マイページの場合 true
     * @return void
     */
    function sfCustomerRegisterParam(&$objFormParam, $isAdmin = false, $is_mypage = false) {
        parent::sfCustomerRegisterParam(&$objFormParam, $isAdmin, $is_mypage);
        $objFormParam->overwriteParam('reminder', 'disp_name', 'パスワードを忘れたときのヒント 質問');
        $objFormParam->overwriteParam('reminder_answer', 'disp_name', 'パスワードを忘れたときのヒント 答え');
    }

    /**
     * 会員エラーチェック共通
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @access private
     * @return array エラー情報の配列
     */
    function sfCustomerCommonErrorCheck(&$objFormParam) {
        //$objErr = parent::sfCustomerCommonErrorCheck($objFormParam);
        $objFormParam->convParam();
        $objFormParam->toLower('email');
        $objFormParam->toLower('email02');
        $arrParams = $objFormParam->getHashArray();

        // 入力データを渡す。
        $objErr = new SC_CheckError_Ex($arrParams);
        $objErr->arrErr = $objFormParam->checkError();

        $objErr->doFunc(array('お電話番号', 'tel01', 'tel02', 'tel03'),array('TEL_CHECK'));
        //$objErr->doFunc(array('FAX番号', 'fax01', 'fax02', 'fax03') ,array('TEL_CHECK'));
        $objErr->doFunc(array('ケータイ番号', 'fax01', 'fax02', 'fax03') ,array('TEL_CHECK'));
        $objErr->doFunc(array('郵便番号', 'zip01', 'zip02'), array('ALL_EXIST_CHECK'));

        return $objErr;
    }
}
