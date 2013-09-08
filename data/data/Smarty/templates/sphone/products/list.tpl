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

<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/products.js"></script>
<script type="text/javascript">//<![CDATA[
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
//]]></script>

<section id="product_list">
    <form name="form1" id="form1" method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="mode" value="<!--{$mode|h}-->" />
        <input type="hidden" name="category_id" value="<!--{$arrSearchData.category_id|h}-->" />
        <input type="hidden" name="maker_id" value="<!--{$arrSearchData.maker_id|h}-->" />
        <input type="hidden" name="name" value="<!--{$arrSearchData.name|h}-->" />
        <input type="hidden" name="orderby" value="<!--{$orderby|h}-->" />
        <input type="hidden" name="disp_number" value="<!--{$disp_number|h}-->" />
        <input type="hidden" name="pageno" value="<!--{$tpl_pageno|h}-->" />
        <input type="hidden" name="product_id" value="" />
        <input type="hidden" name="classcategory_id1" value="" />
        <input type="hidden" name="classcategory_id2" value="" />
        <input type="hidden" name="product_class_id" value="" />
        <input type="hidden" name="quantity" value="" />
        <input type="hidden" name="rnd" value="<!--{$tpl_rnd|h}-->" />
    </form>

    <!--{if $tpl_subtitle =="検索結果"}-->
        <nav id="breadcrumbs">
            <p><a href="<!--{$smarty.const.ROOT_URLPATH}-->">トップページ</a> &gt; <!--{$tpl_subtitle|h}--></p>
        </nav>
        <h2 class="title"><!--{$tpl_subtitle|h}--></h2>
        <section id="lead">
            <p class="center">全<!--{$tpl_linemax|h}-->件</p>
            <div class="results">
                <p>カテゴリ：<strong><!--{$arrSearch.category|h}--></strong><br>
                    <!--{if $arrSearch.maker|strlen >= 1}-->メーカー：<strong><!--{$arrSearch.maker|h}--></strong><br><!--{/if}-->
                    キーワード：<strong><!--{$arrSearch.name|h}--></strong></p>
            </div>
        </section>
    <!--{else}-->
        <nav id="breadcrumbs">
            <p><!--{$tpl_topicpath}--></p>
        </nav>
        <h2 class="title"><!--{$tpl_subtitle|h}--></h2>
        <section id="lead">
            <p>ルート2の<!--{$tpl_subtitle|h}-->一覧です</p>
        </section>
    <!--{/if}-->
    <section id="refine">
        <ul id="tab">
            <li class="selected left"><span><img src="<!--{$TPL_URLPATH}-->img/common/arrow_down.png" alt="">絞り込み</span></li>
            <li class="right"><span><img src="<!--{$TPL_URLPATH}-->img/common/arrow_down.png" alt="">並べ替え</span></li>
        </ul>
        <div>
            <!--直下のカテゴリここから-->
            <!--{assign var=idx value=0}-->
            <!--{section name=cnt loop=$arr_cat_under_name}-->
                <!--{if  $idx>0 }-->　|　<!--{/if}-->
                <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arr_cat_under_id[cnt]}-->"><!--{$arr_cat_under_name[cnt]}--></a>
                <!--{assign var=idx value=$idx+1}-->
            <!--{/section}-->
            <!--直下のカテゴリここまで-->
        </div>
        <div class="hide">
            <a href="javascript:fnChangeOrderby('takai');">価格の高い順</a>
            　|　
            <a href="javascript:fnChangeOrderby('price');">価格の低い順</a>
        </div>
    </section>
<!--{*
    <p class="intro clear"><span class="attention"><span id="productscount"><!--{$tpl_linemax}--></span>件</span>の商品がございます。</p>

    <!--▼ページナビ(本文)-->
    <section class="pagenumberarea clearfix">
        <ul>
            <!--{if $orderby != 'price'}-->
                <li><a href="javascript:fnChangeOrderby('price');" rel="external">価格順</a></li>
            <!--{else}-->
                <li class="on_number">価格順</li>
            <!--{/if}-->
            <!--{if $orderby != "date"}-->
                <li><a href="javascript:fnChangeOrderby('date');" rel="external">新着順</a></li>
            <!--{else}-->
                <li class="on_number">新着順</li>
            <!--{/if}-->
        </ul>
    </section>
    <!--▲ページナビ(本文)-->
*}-->
    <section id="itemlist">
    <!--{foreach from=$arrProducts item=arrProduct name=arrProducts}-->
        <!--{assign var=id value=$arrProduct.product_id}-->
        <!--{assign var=arrErr value=$arrProduct.arrErr}-->
        <!--▼商品-->
        <article>
            <dl>
                <!--★画像★-->
                <dt class=""><img src="<!--{$smarty.const.ROOT_URLPATH}-->resize_image.php?image=<!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->&amp;width=80&amp;height=80"  alt="<!--{$arrProduct.name|h}-->" /></dt>
            <dd class="">
<!--{*
                <div class="statusArea">
                    <!--▼商品ステータス-->
                    <!--{if count($productStatus[$id]) > 0}-->
                        <ul class="status_icon">
                            <!--{foreach from=$productStatus[$id] item=status}-->
                                <li><!--{$arrSTATUS[$status]}--></li>
                            <!--{/foreach}-->
                        </ul>
                    <!--{/if}-->
                    <!--▲商品ステータス-->
                </div>
*}-->
                <!--★商品名★-->
                <h3><a rel="external" href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->" name="product<!--{$arrProduct.product_id}-->" class="productName"><!--{$arrProduct.name|h}--></a></h3>

                <!--★商品価格★-->
                <p>
                    <!--{*<span class="pricebox sale_price"><span class="mini">販売価格(税込):</span></span>*}-->
                    <span class="price"><!--{strip}-->
                        <strong><span id="price02_default_<!--{$id}-->">
                            <!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
                                <!--{$arrProduct.price02_min_inctax|number_format}-->
                            <!--{else}-->
                                <!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
                            <!--{/if}-->
                        </span><span id="price02_dynamic_<!--{$id}-->">
                        </span>円</strong>（税込）
                    <!--{/strip}--></span>
                </p>
<!--{*
                <!--★商品コメント★-->
                <p class="listcomment"><!--{$arrProduct.main_list_comment|h|nl2br}--></p>
*}-->
                </dd>
            </dl>
        </article>
        <!--▲商品-->

    <!--{foreachelse}-->
        <!--{include file="frontparts/search_zero.tpl"}-->
    <!--{/foreach}-->
        <nav>
            <ul>
                <!--{$tpl_strnavi}-->
            </ul>
        </nav>
    </section>

<!--{*
    <!--{if count($arrProducts) < $tpl_linemax}-->
        <div class="btn_area">
            <p><a rel="external" href="javascript: void(0);" class="btn_more" id="btn_more_product" onClick="getProducts(<!--{$disp_number|h}-->); return false;">もっとみる(＋<!--{$disp_number|h}-->件)</a></p>
        </div>
    <!--{/if}-->
*}-->
</section>
<!--{*
<!--▼検索バー -->
<section id="search_area">
    <form method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="mode" value="search" />
        <input type="search" name="name" id="search" value="" placeholder="キーワードを入力" class="searchbox" >
    </form>
</section>
<!--▲検索バー -->
*}-->
<script>
    var pageNo = 2;
    var url = "<!--{$smarty.const.P_DETAIL_URLPATH}-->";
    var imagePath = "<!--{$smarty.const.IMAGE_SAVE_URLPATH|sfTrimURL}-->/";
    var statusImagePath = "<!--{$TPL_URLPATH}-->";

    function getProducts(limit) {
        $.mobile.showPageLoadingMsg();
        var i = limit;
        //送信データを準備
        var postData = {};
        $('#form1').find(':input').each(function(){
            postData[$(this).attr('name')] = $(this).val();
        });
        postData["mode"] = "json";
        postData["pageno"] = pageNo;

        $.ajax({
            type: "POST",
            data: postData,
            url: "<!--{$smarty.const.ROOT_URLPATH}-->products/list.php",
            cache: false,
            dataType: "json",
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert(textStatus);
                $.mobile.hidePageLoadingMsg();
            },
            success: function(result){
                var productStatus = result.productStatus;
                for (var product_id in result) {
                    if (isNaN(product_id)) continue;
                    var product = result[product_id];
                    var productHtml = "";
                    var maxCnt = $(".list_area").length - 1;
                    var productEl = $(".list_area").get(maxCnt);
                    productEl = $(productEl).clone(true).insertAfter(productEl);
                    maxCnt++;

                    //商品写真をセット
                    $($(".list_area .listphoto img").get(maxCnt)).attr({
                        src: "<!--{$smarty.const.ROOT_URLPATH}-->resize_image.php?image=" + product.main_list_image + '&width=80&height=80',
                        alt: product.name
                    });

                    // 商品ステータスをセット
                    var statusAreaEl = $($(".list_area div.statusArea").get(maxCnt));
                    // 商品ステータスの削除
                    statusAreaEl.empty();

                    if (productStatus[product.product_id] != null) {
                        var statusEl = '<ul class="status_icon">';
                        var statusCnt = productStatus[product.product_id].length;
                        for (var k = 0; k < statusCnt; k++) {
                            var status = productStatus[product.product_id][k];
                            var statusImgEl = '<li>' + status.status_name + '</li>' + "\n";
                            statusEl += statusImgEl;
                        }
                        statusEl += "</ul>";
                        statusAreaEl.append(statusEl);
                    }

                    //商品名をセット
                    $($(".list_area a.productName").get(maxCnt)).text(product.name);
                    $($(".list_area a.productName").get(maxCnt)).attr("href", url + product.product_id);

                    //販売価格をセット
                    var price = $($(".list_area span.price").get(maxCnt));
                    //販売価格をクリア
                    price.empty();
                    var priceVale = "";
                    //販売価格が範囲か判定
                    if (product.price02_min == product.price02_max) {
                        priceVale = product.price02_min_tax_format + '円';
                    } else {
                        priceVale = product.price02_min_tax_format + '～' + product.price02_max_tax_format + '円';
                    }
                    price.append(priceVale);

                    //コメントをセット
                    $($(".list_area .listcomment").get(maxCnt)).text(product.main_list_comment);
                }
                pageNo++;

                //すべての商品を表示したか判定
                if (parseInt($("#productscount").text()) <= $(".list_area").length) {
                    $("#btn_more_product").hide();
                }
                $.mobile.hidePageLoadingMsg();
            }
        });
    }
</script>
