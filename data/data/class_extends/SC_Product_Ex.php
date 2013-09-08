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

require_once CLASS_REALDIR . 'SC_Product.php';

class SC_Product_Ex extends SC_Product {
    /**
     * 商品規格IDから商品規格を取得する.
     *
     * 削除された商品規格は取得しない.
     *
     * @param integer $productClassId 商品規格ID
     * @return array 商品規格の配列
     */
    function getProductsClass($productClassId) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        //$objQuery->setWhere('product_class_id = ? AND T1.del_flg = 0');
        $objQuery->setWhere('T1.product_class_id = ? AND T1.del_flg = 0'); // エラーになる？？？
        $arrRes = $this->getProductsClassByQuery($objQuery, $productClassId);
        return (array)$arrRes[0];
    }

    /**
     * 複数の商品IDに紐づいた, 商品規格を取得する.
     *
     * @param array $productIds 商品IDの配列
     * @param boolean $has_deleted 削除された商品規格も含む場合 true; 初期値 false
     * @return array 商品規格の配列
     */
    function getProductsClassByProductIds($productIds = array(), $has_deleted = false) {
        if (empty($productIds)) {
            return array();
        }
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        //$where = 'product_id IN (' . SC_Utils_Ex::repeatStrWithSeparator('?', count($productIds)) . ')';
        $where = 'T1.product_id IN (' . SC_Utils_Ex::repeatStrWithSeparator('?', count($productIds)) . ')'; // エラー発生対処
        if (!$has_deleted) {
            $where .= ' AND T1.del_flg = 0';
        }
        $objQuery->setWhere($where);
        return $this->getProductsClassByQuery($objQuery, $productIds);
    }

    /**
     * 商品IDに紐づく商品規格を自分自身に設定する.
     *
     * 引数の商品IDの配列に紐づく商品規格を取得し, 自分自身のフィールドに
     * 設定する.
     *
     * @param array $arrProductId 商品ID の配列
     * @param boolean $has_deleted 削除された商品規格も含む場合 true; 初期値 false
     * @return void
     */
    function setProductsClassByProductIds($arrProductId, $has_deleted = false) {
        parent::setProductsClassByProductIds($arrProductId, $has_deleted);

        foreach ($arrProductId as $productId) {
            // 規格1
            $this->classCats1[$productId]['__unselected'] = '選択して下さい';
        }
    }
    /**
     * 商品詳細の SQL を取得する.
     *
     * @param string $where_products_class 商品規格情報の WHERE 句
     * @return string 商品詳細の SQL
     */
    function alldtlSQL($where_products_class = '') {
        if (!SC_Utils_Ex::isBlank($where_products_class)) {
            $where_products_class = 'AND (' . $where_products_class . ')';
        }
        /*
         * point_rate, deliv_fee は商品規格(dtb_products_class)ごとに保持しているが,
         * 商品(dtb_products)ごとの設定なので MAX のみを取得する.
         */
        $sql = <<< __EOS__
            (
                SELECT
                     dtb_products.product_id
                    ,dtb_products.name
                    ,dtb_products.maker_id
                    ,dtb_products.status
                    ,dtb_products.comment1
                    ,dtb_products.comment2
                    ,dtb_products.comment3
                    ,dtb_products.comment4
                    ,dtb_products.comment5
                    ,dtb_products.comment6
                    ,dtb_products.note
                    ,dtb_products.main_list_comment
                    ,dtb_products.main_list_image
                    ,dtb_products.main_comment
                    ,dtb_products.main_image
                    ,dtb_products.main_large_image
                    ,dtb_products.sub_title1
                    ,dtb_products.sub_comment1
                    ,dtb_products.sub_image1
                    ,dtb_products.sub_large_image1
                    ,dtb_products.sub_title2
                    ,dtb_products.sub_comment2
                    ,dtb_products.sub_image2
                    ,dtb_products.sub_large_image2
                    ,dtb_products.sub_title3
                    ,dtb_products.sub_comment3
                    ,dtb_products.sub_image3
                    ,dtb_products.sub_large_image3
                    ,dtb_products.sub_title4
                    ,dtb_products.sub_comment4
                    ,dtb_products.sub_image4
                    ,dtb_products.sub_large_image4
                    ,dtb_products.sub_title5
                    ,dtb_products.sub_comment5
                    ,dtb_products.sub_image5
                    ,dtb_products.sub_large_image5
                    ,dtb_products.sub_title6
                    ,dtb_products.sub_comment6
                    ,dtb_products.sub_image6
                    ,dtb_products.sub_large_image6
                    ,dtb_products.del_flg
                    ,dtb_products.creator_id
                    ,dtb_products.create_date
                    ,dtb_products.update_date
                    ,dtb_products.deliv_date_id
                    ,dtb_products.unit_id
                    ,dtb_products.option_item_flg
                    ,dtb_products.semi_order_made_flg
                    ,dtb_products.sell_piece_flg
                    ,dtb_products.order_made_flg
                    ,dtb_products.body_color_class_id
                    ,dtb_products.back_color_class_id
                    ,dtb_products.edge_color_class_id
                    ,dtb_products.edge_size_class_id
                    ,T4.product_code_min
                    ,T4.product_code_max
                    ,T4.price01_min
                    ,T4.price01_max
                    ,T4.price02_min
                    ,T4.price02_max
                    ,T4.stock_min
                    ,T4.stock_max
                    ,T4.stock_unlimited_min
                    ,T4.stock_unlimited_max
                    ,T4.point_rate
                    ,T4.deliv_fee
                    ,T4.class_count
                    ,dtb_maker.name AS maker_name
                FROM dtb_products
                    JOIN (
                        SELECT product_id,
                            MIN(product_code) AS product_code_min,
                            MAX(product_code) AS product_code_max,
                            MIN(price01) AS price01_min,
                            MAX(price01) AS price01_max,
                            MIN(price02) AS price02_min,
                            MAX(price02) AS price02_max,
                            MIN(stock) AS stock_min,
                            MAX(stock) AS stock_max,
                            MIN(stock_unlimited) AS stock_unlimited_min,
                            MAX(stock_unlimited) AS stock_unlimited_max,
                            MAX(point_rate) AS point_rate,
                            MAX(deliv_fee) AS deliv_fee,
                            COUNT(*) as class_count
                        FROM dtb_products_class
                        WHERE del_flg = 0 $where_products_class
                        GROUP BY product_id
                    ) AS T4
                        ON dtb_products.product_id = T4.product_id
                    LEFT JOIN dtb_maker
                        ON dtb_products.maker_id = dtb_maker.maker_id
            ) AS alldtl
__EOS__;
        return $sql;
    }

    /**
     * SC_Queryインスタンスに設定された検索条件をもとに商品一覧の配列を取得する.
     *
     * 主に SC_Product::findProductIds() で取得した商品IDを検索条件にし,
     * SC_Query::setOrder() や SC_Query::setLimitOffset() を設定して, 商品一覧
     * の配列を取得する.
     *
     * @param SC_Query $objQuery SC_Query インスタンス
     * @return array 商品一覧の配列
     */
    function lists(&$objQuery) {
        $col = <<< __EOS__
             product_id
            ,product_code_min
            ,product_code_max
            ,name
            ,comment1
            ,comment2
            ,comment3
            ,main_list_comment
            ,main_image
            ,main_list_image
            ,price01_min
            ,price01_max
            ,price02_min
            ,price02_max
            ,stock_min
            ,stock_max
            ,stock_unlimited_min
            ,stock_unlimited_max
            ,deliv_date_id
            ,status
            ,del_flg
            ,update_date
            ,option_item_flg
            ,semi_order_made_flg
            ,sell_piece_flg
            ,order_made_flg
            ,body_color_class_id
            ,back_color_class_id
            ,edge_color_class_id
            ,edge_size_class_id
__EOS__;
        $res = $objQuery->select($col, $this->alldtlSQL());
        return $res;
    }

}
