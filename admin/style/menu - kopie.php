{category}
<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#{category_name}" href="#{category_name}">
      <i class="icon-user"></i>{category_name}
    </a>

  </div>
  <div id="{category_name}" class="accordion-body collapse">
  	{/category}
    <div class="accordion-inner">
      {ul}
        {item}<li><a href="{item_link}">{item_name}</a></li>{/item}
      {/ul}
    </div>
  </div>
</div>