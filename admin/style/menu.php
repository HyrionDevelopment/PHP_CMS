{category}
<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#apps" href="#{category_alias}" id="menu_app_{category_alias}">
      <i class="{category_icon}"></i>{category_name}
    </a>

  </div>
  <div id="{category_alias}" class="accordion-body collapse">
    <div class="accordion-inner">
      {ul}
        {item}<li><a href="{item_link}">{item_name}</a></li>{/item}
      {/ul}
    </div>
  </div>
</div>
{/category}