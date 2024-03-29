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
<!--{*
<!--{if count($arrBestProducts) > 0}-->
    <div class="block_outer clearfix">
        <div id="recommend_area">
            <h2><img src="<!--{$TPL_URLPATH}-->img/title/tit_bloc_recommend.jpg" alt="*" class="title_icon" /></h2>
            <div class="block_body clearfix">
                <!--{foreach from=$arrBestProducts item=arrProduct name="recommend_products"}-->
                    <div class="product_item clearfix">
                        <div class="productImage">
                            <a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->">
                                <img src="<!--{$smarty.const.ROOT_URLPATH}-->resize_image.php?image=<!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->&amp;width=80&amp;height=80" alt="<!--{$arrProduct.name|h}-->" />
                            </a>
                        </div>
                        <div class="productContents">
                            <h3>
                                <a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->"><!--{$arrProduct.name|h}--></a>
                            </h3>
                            <p class="sale_price">
                                <!--{$smarty.const.SALE_PRICE_TITLE}-->(税込)： <span class="price"><!--{$arrProduct.price02_min_inctax|number_format}--> 円</span>
                            </p>
                            <p class="mini comment"><!--{$arrProduct.comment|h|nl2br}--></p>
                        </div>
                    </div>
                    <!--{if $smarty.foreach.recommend_products.iteration % 2 === 0}-->
                        <div class="clear"></div>
                    <!--{/if}-->
                <!--{/foreach}-->
            </div>
        </div>
    </div>
<!--{/if}-->
*}-->
<div id="rankingarea">
    <!--{* 内装ランキング *}-->
    <div id="rankingarea_naisou">
        <!--{assign var=idx value=1}-->
        <div style="width:160px;">
        <!-- 内装ランキングタグ -->
            <script type="text/javascript">
            <!--
            if (!window._rcmdjp) document.write(unescape("%3Cscript src='" + document.location.protocol + "//d.rcmd.jp/www.route-2.net/item/recommend.js' type='text/javascript' charset='UTF-8'%3E%3C/script%3E"));
            //-->
            </script>
            <script type="text/javascript">
            <!--
            try{
              _rcmdjp._displayRanking({
                type: 'pv',
                span: 'week',
                template: 'top-right-ranking-naisou',
                category: '内装・インテリア'
              });
            } catch(err) {}
            //-->
            </script>
        <!-- 内装ランキングタグ -->
        </div>
    </div>
    
    
    <!--{* 外装ランキング *}-->
    <div id="rankingarea_gaisou">
        <!--{assign var=idx value=1}-->
        <div style="width:160px;">
        <!-- 外装ランキングタグ -->
            <script type="text/javascript">
            <!--
            try{
              _rcmdjp._displayRanking({
                type: 'pv',
                span: 'week',
                template: 'top-right-ranking-gaisou',
                category: '外装'
              });
            } catch(err) {}
            //-->
            </script>
        <!-- 外装ランキングタグ -->
        </div>
    </div>
</div>