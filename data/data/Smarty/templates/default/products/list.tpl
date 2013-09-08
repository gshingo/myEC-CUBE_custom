<!--{*
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
 *}-->

<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/products.js"></script>
<script type="text/javascript">//<![CDATA[
    function fnSetClassCategories(form, classcat_id2_selected) {
    //    var $form = $(form);
    //    var product_id = $form.find('input[name=product_id]').val();
    //    var $sele1 = $form.find('select[name=classcategory_id1]');
    //    var $sele2 = $form.find('select[name=classcategory_id2]');
    //    setClassCategories($form, product_id, $sele1, $sele2, classcat_id2_selected);
    }
    // 並び順を変更
    function fnChangeOrderby(orderby) {
        fnSetVal('orderby', orderby);
        fnSetVal('pageno', 1);
        fnSubmit();
    }
    // 表示件数を変更
    function fnChangeDispNumber(dispNumber) {
        fnSetVal('disp_number', dispNumber);
        fnSetVal('pageno', 1);
        fnSubmit();
    }
    // カゴに入れる
    function fnInCart(productForm) {
        var searchForm = $("#form1");
        var cartForm = $(productForm);
        // 検索条件を引き継ぐ
        var hiddenValues = ['mode','category_id','maker_id','name','orderby','disp_number','pageno','rnd'];
        $.each(hiddenValues, function(){
            // 商品別のフォームに検索条件の値があれば上書き
            if (cartForm.has('input[name='+this+']')) {
                cartForm.find('input[name='+this+']').val(searchForm.find('input[name='+this+']').val());
            }
            // なければ追加
            else {
                cartForm.append($("<input/>").attr("name", this).val(searchForm.find('input[name='+this+']').val()));
            }
        });
        // 商品別のフォームを送信
        cartForm.submit();
    }
document.write(unescape("%3Cscript src='" + document.location.protocol + "//d.rcmd.jp/www.route-2.net/item/recommend.js' type='text/javascript' charset='UTF-8'%3E%3C/script%3E"));


//]]></script>

<div id="undercolumn">
    <form name="form1" id="form1" method="get" action="?">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="mode" value="<!--{$mode|h}-->" />
        <!--{* ▼検索条件 *}-->
        <input type="hidden" name="category_id" value="<!--{$arrSearchData.category_id|h}-->" />
        <input type="hidden" name="maker_id" value="<!--{$arrSearchData.maker_id|h}-->" />
        <input type="hidden" name="name" value="<!--{$arrSearchData.name|h}-->" />
        <!--{* ▲検索条件 *}-->
        <!--{* ▼ページナビ関連 *}-->
        <input type="hidden" name="orderby" value="<!--{$orderby|h}-->" />
        <input type="hidden" name="disp_number" value="<!--{$disp_number|h}-->" />
        <input type="hidden" name="pageno" value="<!--{$tpl_pageno|h}-->" />
        <!--{* ▲ページナビ関連 *}-->
        <!--{* ▼注文関連 *}-->
        <input type="hidden" name="product_id" value="" />
        <input type="hidden" name="classcategory_id1" value="" />
        <input type="hidden" name="classcategory_id2" value="" />
        <input type="hidden" name="product_class_id" value="" />
        <input type="hidden" name="quantity" value="" />
        <!--{* ▲注文関連 *}-->
        <input type="hidden" name="rnd" value="<!--{$tpl_rnd|h}-->" />
    </form>

    <!--★タイトル★-->
      <div id="listtitle">
          <br />
          <sub_title>
            <font size="5"><b><!--★タイトル★--><!--{$tpl_subtitle|h}--></b></font>
            <font color="#666666">
            　[ 全 <!--{$tpl_linemax|h}--> 件 ]
            <br />
            
            <span style="float: right; margin-right: 20px;">
            ルート２の<!--{$tpl_subtitle|h}-->一覧です。
            </span>
            </font>
          </sub_title>
      </div>

    <!--{if $tpl_doro_flg }-->
    <!--泥除けのバナーおよびリンク張る箇所-->
    <!--{/if}-->

    <!--▼検索条件-->
    <!--{if $tpl_subtitle == "検索結果"}-->
        <!--検索条件ここから-->
        <span class="pagecondarea">
            カテゴリ：<strong><!--{$arrSearch.category|h}--></strong>
            <!--{if $arrSearch.maker|strlen >= 1}-->メーカー：<strong><!--{$arrSearch.maker|h}--></strong><!--{/if}-->
            キーワード：<strong><!--{$arrSearch.name|h}--></strong>
        </span>
        <!--検索条件ここまで-->
    <!--{else}-->
        <!--直下のカテゴリここから-->
        <!--{assign var=idx value=0}-->
        <!--{section name=cnt loop=$arr_cat_under_name}-->
            <!--{if  $idx>0 }-->
                　|　
            <!--{/if}-->
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arr_cat_under_id[cnt]}-->">
            <!--{$arr_cat_under_name[cnt]}-->
            </a>
            <!--{assign var=idx value=$idx+1}-->
        <!--{/section}-->
        <!--直下のカテゴリここまで-->
        <br>
        <br>
        <img src="<!--{$TPL_URLPATH}-->img/common/line_710.gif" width="710" height="1" alt="line_710" name="line_710" id="line_710" />
    <!--{/if}-->
    <!--▲検索条件-->

    <!--▼ページナビ(本文)-->
    <!--{capture name=page_navi_body}-->
        <span class="pagenumber_area clearfix">
            <div class="navi">
                <span style="float: left;"><!--{$tpl_hitnum_start}--> ～ <!--{$tpl_hitnum_end}-->件表示</span>
                <span style="float: right;"><!--{$tpl_strnavi}--></span>
            </div>
        </span>
    <!--{/capture}-->
    <!--▲ページナビ(本文)-->

    <!--{foreach from=$arrProducts item=arrProduct name=arrProducts}-->

        <!--{if $smarty.foreach.arrProducts.first}-->
            <!--▼件数-->
            <!--▲件数-->

            <!--▼ページナビ(上部)-->
            <span class="pagenumber_area" style="font-size:14px;">
                <span class="change"<!--{if $tpl_subtitle != "検索結果"}--> style="margin-top:10px;"<!--{/if}-->>
                    並び替え：
                    <a class="pagenum_gray" href="javascript:fnChangeOrderby('takai');">価格の高い順</a>
                    　|&nbsp;&nbsp;
                    <a class="pagenum_gray" href="javascript:fnChangeOrderby('price');">価格の低い順</a>
                </span>
            </span>
            <form name="page_navi_top" id="page_navi_top" action="?">
                <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
                <!--{if $tpl_linemax > 0}--><!--{$smarty.capture.page_navi_body|smarty:nodefaults}--><!--{/if}-->
            </form>
            <!--▲ページナビ(上部)-->
            <div style="margin: 9px 0px 0px 0px;">
                <img src="<!--{$TPL_URLPATH}-->img/common/line_710.gif" width="710" height="1" alt="line_710" name="line_710" id="line_710" />
            </div>
            <div style="margin-top: 10px;">
                <img src="<!--{$TPL_URLPATH}-->img/common/send_free.gif" width="710" height="22" alt="send_free" name="send_free" id="send_free" />
            </div>
        <!--{/if}-->

        <!--{assign var=id value=$arrProduct.product_id}-->
        <!--{assign var=arrErr value=$arrProduct.arrErr}-->
        <!--▼商品-->
        <form name="product_form<!--{$id|h}-->" action="?" onsubmit="return false;">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <div class="list_area clearfix">
            <a name="product<!--{$id|h}-->"></a>
            <div class="listphoto" style="height:130px">
                <!--★画像★-->
                <a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->">
                    <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrProduct.name|h}-->" class="picture" /></a>
            </div>

            <div class="listrightbloc">
                <!--▼商品ステータス-->
                <!--▲商品ステータス-->

                <!--★商品名★-->
                <h3>
                    <a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->"><!--{$arrProduct.name|h}--></a>
                </h3>
                <!--★価格★-->
                <div class="pricebox sale_price">
                    <!--{*
                    <span class="price">
                        <span id="price02_default_<!--{$id}-->"><!--{strip}-->
                            <!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
                                <!--{$arrProduct.price02_min_inctax|number_format}-->
                            <!--{else}-->
                                <!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
                            <!--{/if}-->
                        </span><span id="price02_dynamic_<!--{$id}-->"></span><!--{/strip}-->
                        円(税込)</span>
                    *}-->
                    <!--価格-->
                    <p><!--{strip}-->
                        <!--{if $arrPriceDown[$id] == 1}-->
                            <span class="price">
                                <!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
                                    <!--{$arrProduct.price02_min_inctax|number_format}-->
                                <!--{else}-->
                                    <!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
                                <!--{/if}-->&nbsp;円(税込)
                            </span>
                        <!--{else}-->
                            <s>
                                <span class="price">
                                    <!--{if $arrProduct.price01_min_inctax == $arrProduct.price01_max_inctax}-->
                                        <!--{$arrProduct.price01_min_inctax|number_format}-->
                                    <!--{else}-->
                                        <!--{$arrProduct.price01_min_inctax|number_format}-->～<!--{$arrProduct.price01_max_inctax|number_format}-->
                                    <!--{/if}-->&nbsp;円(税込)
                                </span>
                            </s><br>
                            <span class="price_down">
                                ↓<br>
                                <!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
                                    <!--{$arrProduct.price02_min_inctax|number_format}-->
                                <!--{else}-->
                                    <!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
                                <!--{/if}-->&nbsp;円(税込)
                            </span>
                        <!--{/if}-->
                    <!--{/strip}--></p>
                    <!--価格-->
                </div>

                <!--★コメント★-->

                <!--★商品詳細を見る★-->

<!--// 販売期限による分岐 //-->
                <!--▼買い物かご-->
                <!--▲買い物かご-->
<!--// 販売期限による分岐 //-->
            </div>
        </div>
        </form>
        <!--▲商品-->

        <!--{if $smarty.foreach.arrProducts.last}-->
            <div style="margin: 10px 0px 10px 0px;">
                <img src="<!--{$TPL_URLPATH}-->img/common/line_710.gif" width="710" height="1" alt="line_710" name="line_710" id="line_710" />
            </div>
            <!--▼ページナビ(下部)-->
            <form name="page_navi_bottom" id="page_navi_bottom" action="?">
                <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
                <!--{if $tpl_linemax > 0}--><!--{$smarty.capture.page_navi_body|smarty:nodefaults}--><!--{/if}-->
            </form>
            <!--▲ページナビ(下部)-->
        <!--{/if}-->

    <!--{foreachelse}-->
        <div style="margin: 10px 0px 0px 0px;">
            <img src="<!--{$TPL_URLPATH}-->img/common/line_710.gif" width="710" height="1" alt="line_710" name="line_710" id="line_710" />
        </div>
        <div style="margin-top: 10px;">
            <img src="<!--{$TPL_URLPATH}-->img/common/send_free.gif" width="710" height="22" alt="send_free" name="send_free" id="send_free" />
            <img src="<!--{$TPL_URLPATH}-->img/common/line_710.gif" width="710" height="1" alt="line_710" name="line_710" id="line_710" />
        </div>
        <!--{include file="frontparts/search_zero.tpl"}-->
    <!--{/foreach}-->
        <div style="position: relative; top: 15px; left: 560px; width: 100px;">
            <a href="#top"><img src="<!--{$TPL_URLPATH}-->img/common/back_top_btn.gif" width="150" height="25" alt="TOP戻る" name="top_back" id="top_back" /></a>
        </div>
        <div style="margin-top: 48px;">
            <img src="<!--{$TPL_URLPATH}-->img/common/send_free.gif" width="710" height="22" alt="send_free" name="send_free" id="send_free" />
        </div>
        <!--{if $tpl_subtitle == "検索結果"}-->
            <br />
        <!--{/if}-->
</div>
