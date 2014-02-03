<h2>{$LANG.catalogue.product_info}</h2>
{if isset($PRODUCT) && $PRODUCT}
<form action="{$VAL_SELF}" method="post" class="addForm">
	<div>
		<div id="gallery">
			<div class="image">
				{if $PRODUCT.magnify}
					<a href="{$PRODUCT.source}" class="magnify" title="{$PRODUCT.name}" rel="">
					  <img src="{$PRODUCT.medium}" alt="{$PRODUCT.name}" id="preview" />
					</a>
					<p class="hover_zoom">{$LANG.catalogue.hover_zoom}</p>
				{else}
					<img src="{$PRODUCT.medium}" alt="{$PRODUCT.name}" id="preview" />
				{/if}
			</div>
			{if $GALLERY}
			<div id="gallery_select">
				{foreach from=$GALLERY item=image}
				<a href="{$image.large}" id="image_{$image.id}" class="colorbox gallery" rel="gallery"><img src="{$image.gallery}" alt="{$LANG.catalogue.click_enlarge}" /></a>
				{/foreach}
			</div>
			<script type="text/javascript">
				var gallery_json	= {$GALLERY_JSON}
			</script>
			{/if}
		</div>
		<div id="product_detail">
			<h3>{$PRODUCT.name}</h3>
	  		<p>
	  			<strong>{$LANG.catalogue.product_code}</strong>: {$PRODUCT.product_code}
	  		</p>

	  		{if $PRODUCT.review_score && $CTRL_REVIEW}
	  		<p class="rating">
	  		{for $i = 1; $i <= 5; $i++}
	  			{if $PRODUCT.review_score >= $i}
				<img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/star.png" alt="" />
				{elseif $PRODUCT.review_score > ($i - 1) && $PRODUCT.review_score < $i}
				<img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/star_half.png" alt="" />
				{else}
				<img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/star_off.png" alt="" />
				{/if}
	  		{/for}
	  		</p>
	  		<p class="rating-info">{$LANG_REVIEW_INFO}</p>
	  		{/if}

	  		<div id="product_description">
			{$PRODUCT.description}
  	  		</div>

	  		{if $PRODUCT.manufacturer}
	  		<p>{$LANG.catalogue.manufacturer}: {$MANUFACTURER}</p>
	  		{/if}
	  		{if $PRODUCT.stock_level}
	 		<p>{$LANG.catalogue.stock_level}: {$PRODUCT.stock_level}</p>
	  		{/if}

	  		{if is_array($OPTIONS)}
	  		<div class="options">
			{foreach from=$OPTIONS item=option}
		  		{if $option.type == '0'}
				<div>
		  			<label for="option_{$option.option_id}" class="return">{$option.option_name}{if $option.price} ({$option.symbol}{$option.price}){/if}{if $option.required} *{/if}</label>
		  			<span>
		  				<select name="productOptions[{$option.option_id}]" id="option_{$option.option_id}" class="textbox {if $option.required}required{/if}">
							<option value="">{$LANG.form.please_select}</option>
							{foreach from=$option.values item=value}
							<option value="{$value.assign_id}">{$value.value_name}{if $value.price} ({$value.symbol}{$value.price}){/if}</option>
							{/foreach}
						</select>
		  			</span>
				</div>

				{else}

				<div>
		  			<label for="option_{$option.option_id}" class="return">{$option.option_name}{if $option.price} ({$option.symbol}{$option.price}){/if}{if $option.required} *{/if}</label>
		  			<span>
			  			{if $option.type == '1'}
			  			<input type="text" name="productOptions[{$option.option_id}][{$OPT.assign_id}]" id="option_{$option.option_id}" class="textbox {if $option.required}required{/if}"  />
			  			{elseif $option.type == '2'}
			  			<textarea name="productOptions[{$option.option_id}][{$OPT.assign_id}]" id="option_{$option.option_id}" class="textbox {if $option.required}required{/if}"></textarea>
			  			{/if}
		  			</span>
				</div>
		 		{/if}
			{/foreach}
	  		</div>
	  		{/if}

	  		<div id="price">
	  		{if $PRODUCT.ctrl_sale}
		  		<span class="price_previous">{$PRODUCT.price}</span>
		  		<span class="price_sale">{$PRODUCT.sale_price}</span>
		  	{else}
		  		{$PRODUCT.price}
		  	{/if}
	  		</div>

	  		{if ($CTRL_ALLOW_PURCHASE) && (!$CATALOGUE_MODE)}
	  		<div class="add_to_basket">
				<input type="text" name="quantity" value="1" class="quantity required" />
				<input type="hidden" name="add" value="{$PRODUCT.product_id}" />
				<input type="submit" value="{$LANG.catalogue.buy}" class="button_buy" />
	  		</div>
	  		{else}
		  		{if $CTRL_HIDE_PRICES}
			  		<p class="buy_button"><strong>{$LANG.catalogue.login_to_view}</strong></p>
			  	{else if $CTRL_OUT_OF_STOCK}
			  		<p class="buy_button"><strong>{$LANG.catalogue.out_of_stock}</strong></p>
			  	{/if}
	  		{/if}

	  		{if isset($PRODUCT.discounts)}
	  		<div id="quantity_discounts">
			<!--<h2>{$LANG.catalogue.quantity_discounts}</h2>-->
			<!--<p>{$LANG.catalogue.quantity_discounts_explained}</p>-->
				<table class="list discounts_table">
		  			<tr>
						<th>{$LANG.common.quantity}</th>
						<th>{$LANG.catalogue.price_per_unit}</th>
		  			</tr>
		  			{foreach from=$PRODUCT.discounts item=discount}
		  			<tr>
						<td align="center">{$discount.quantity}+</td>
						<td align="center">{$discount.price}</td>
		  			</tr>
		  			{/foreach}
				</table>
	  		</div>
	  		{/if}

	  		{if $SHARE}
		  	{foreach from=$SHARE item=html}
		  		{$html}
		  	{/foreach}
		  	{/if}
			{if $CTRL_REVIEW}
			<div id="share_link">
				<a href="{$PRODUCT.url}#reviews">{$LANG.catalogue.customer_reviews}</a>
			</div>
			{/if}
		</div>
	</div>
	</form>

{if $CTRL_REVIEW}
<h2 class="tabbed">{$LANG.catalogue.customer_reviews}</h2>
<div id="reviews">
  <div id="review_read">
  {if $REVIEWS}
	<p class="pagination_top"><span class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</span>{$LANG.catalogue.average_rating}: <strong>{$REVIEW_AVERAGE}</strong></p>
	{foreach from=$REVIEWS item=review}
	<div class="review">
	  <h3>
		<span style="float: right;">
		{for $i = 1; $i <= 5; $i++}
		  {if $i <= $review.rating}
		  <img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/star.png" width="15" height="15" alt="" />
		  {else}
		  <img src="{$STORE_URL}/skins/{$SKIN_FOLDER}/images/star_off.png" width="15" height="15" alt="" />
		  {/if}
		{/for}
		</span>
		{$review.title}
	  </h3>
	  <p class="content">{$review.review}</p>
	  <p class="author">
		{$review.name} :: {$review.date}
	  </p>
	</div>
	{/foreach}
	<p class="pagination_bottom"><span class="pagination">{if isset($PAGINATION)}{$PAGINATION}{/if}</span><a href="#" onclick="$('#review_read').slideToggle(); $('#review_write').slideToggle(); return false;">{$LANG.catalogue.write_a_review}</a></p>
  {else}
	<div>{$LANG.catalogue.product_not_reviewed} <a href="#" onclick="$('#review_read').slideToggle(); $('#review_write').slideToggle(); return false;">{$LANG.catalogue.write_a_review}</a></div>
  {/if}
  </div>

  <div id="review_write" style="display: none;">
	<h3 class="tabbed">{$LANG.catalogue.write_review}</a></h3>
	<form action="{$VAL_SELF}#reviews_write" method="post">
	  <fieldset>
		 {if $IS_USER}
		<div><input type="checkbox" id="rev_anon" name="review[anon]" value="1" /> <label for="rev_anon">{$LANG.catalogue.post_anonymously}</label></div>
		{else}
		<div><label for="rev_name">{$LANG.common.name}</label><span><input id="rev_name" type="text" name="review[name]" value="{$WRITE.name}" class="textbox required" /></span></div>
		<div><label for="rev_email">{$LANG.common.email}</label><span><input id="rev_email" type="text" name="review[email]" value="{$WRITE.email}" class="textbox required" /></span></div>
		{/if}
		<span id="review_stars">
		{foreach from=$RATING_STARS item=star}
		  <input type="radio" id="rating_{$star.value}" name="rating" value="{$star.value}" class="rating" {$star.checked} />
		{/foreach}
		</span>
		<div><label for="rev_title" class="inline">{$LANG.catalogue.review_title}</label><span><input id="rev_title" type="text" name="review[title]" value="{$WRITE.title}" class="textbox required" /></span></div>
		<div><label for="rev_review" class="return">{$LANG.catalogue.review}</label><span><textarea id="rev_review" name="review[review]" class="textbox required" style="height: 70px; width:400px;" rows="10" cols="40">{$WRITE.review}</textarea></span></div>
		{include file='templates/content.recaptcha.php'}
	  </fieldset>
	  <div>
		<input type="submit" value="{$LANG.catalogue.submit_review}" class="button_submit" />
		<input type="button" onclick="$('#review_read').slideToggle(); $('#review_write').slideToggle();" value="{$LANG.common.cancel}" class="button_submit" />
	  </div>
	  	</form>
  </div>
</div>
{/if}

{foreach from=$COMMENTS item=html}
{$html}
{/foreach}

{if isset($TALKBACKS) && $TALKBACKS}
<div>
  <h2>{$LANG.catalogue.trackbacks}</h2>
  {foreach from=$TRACKBACKS item=track}
  <p>
	<a href="{$track.url}" target="_blank">{$track.title}</a><br />
	<blockquote cite="{$track.url}">&quot;{$track.excerpt}&quot;</blockquote>
  </p>
  {/foreach}
  <h3>{$LANG.catalogue.trackback_url}</h3>
  <p>{$TRACKBACK_URL}</p>
</div>
{/if}

{else}
<p>{$LANG.catalogue.product_doesnt_exist}</p>
{/if}