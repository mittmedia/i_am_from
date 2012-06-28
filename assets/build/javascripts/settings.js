(function() {
  var _this = this;

  this.IAmFrom = {
    add_delete_events: function() {
      jQuery('.delete_action').on('click', function() {
        var class_to_hide, class_to_hide_array, element_class, hidden_input;
        hidden_input = jQuery("<input type='hidden' name='" + this.name + "' />");
        jQuery('form').append(hidden_input);
        element_class = jQuery(this).parent().parent().attr('class');
        class_to_hide_array = element_class.split(' ');
        class_to_hide = class_to_hide_array[1];
        jQuery("." + class_to_hide).css('background', '#ffebe8');
        jQuery("." + class_to_hide + "_link").css('background', '#ffebe8');
        jQuery("." + class_to_hide).fadeOut('slow');
        jQuery("." + class_to_hide + "_link").fadeOut('slow');
        jQuery(".spacer:first").fadeOut('slow', function() {
          return jQuery(".spacer:first").remove();
        });
      });
    }
  };

  jQuery(function() {
    _this.IAmFrom.add_delete_events();
  });

}).call(this);
