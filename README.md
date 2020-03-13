# WP Bootstrap NavWalker
A custom WordPress NavWalker class to extend the default WordPress functionality using Bootstrap3.

## Usage
First you need to include this class in your <strong>WordPress Theme Directory</strong> and then open your <strong>functions.php</strong> file and paste the following code.

```ruby
require_once get_template_directory() . '/class-bs-navwalker.php';
```

Now add the class in `wp_nav_menu` function.

`'walker' => new WP_BS_NavWalker()`

### Icon
In this class I use the <strong>FontAwesome Icons</strong> for this you also need to include the FontAwesome Icons in your theme.

```ruby
if ( in_array('menu-item-has-children', $item->classes) && $depth == 0 ) {
  $icon = '<i class="fa fa-angle-down dropdown-toggle" data-toggle="dropdown"></i>';
} elseif ( in_array('menu-item-has-children', $item->classes) && $depth >= 1 ) {
  $icon = '<i class="fa fa-angle-right dropdown-toggle" data-toggle="dropdown"></i>';
}
```

You can also use the Bootstrap Icons.

```ruby
if ( in_array('menu-item-has-children', $item->classes) && $depth == 0 ) {
  $icon = '<i class="glyphicon glyphicon-chevron-down dropdown-toggle" data-toggle="dropdown"></i>';
} elseif ( in_array('menu-item-has-children', $item->classes) && $depth >= 1 ) {
  $icon = '<i class="glyphicon glyphicon-chevron-right dropdown-toggle" data-toggle="dropdown"></i>';
}
```

### JavaScript
Add the active also when we click on the icon to the nearest `li`.

```ruby
jQuery(document).ready(function($){
  $('i.dropdown-toggle').click(function(e){
    e.stopPropagation();
    $(this).closest("li").toggleClass("active");
  });
});
```

### CSS
In CSS add `display: block;` in 'li.active > ul'.
