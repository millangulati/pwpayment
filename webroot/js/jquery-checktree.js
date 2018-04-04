
/**
 * <ul id="tree">
 *   <li><label><input type="checkbox" />Item1</label></li>
 *   <li>
 *     <label><input type="checkbox" />ItemWithSubitems</label>
 *     <ul>
 *       <li><label><input type="checkbox" />Subitem1</label></li>
 *     </ul>
 *   </li>
 * </ul>
 *
 * Usage:
 *
 * $('ul#tree').checktree();
 *
 */

(function($){
    $.fn.extend({

        checktree: function(){
            $(this)
                .addClass('checktree-root')
                .on('change', 'input[type="checkbox"]', function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    if($(this).val() == 'all') {
                        
                        if ($(this).prop("checked") == true) {
                            
                            $(".menurights-js").each(function(){
                                if(!$(this).is(":disabled")) {
                                    $(this).prop('checked',true);
                                }
                                
                            });
                            
                        } else {
                            $(".menurights-js").each(function(){
                                if(!$(this).is(":disabled")) {
                                    $(this).prop('checked',false);
                                }
                                
                            });
                        }
                        
                    } else {
                   
                        checkParents($(this));
                        checkChildren($(this));
                        var totallength = $(".menurights-js").length;
                        var checkedlength = $(".menurights-js:checked").length;
                        if(totallength == checkedlength) {
                            $('.all_chk').prop('checked',true);
                        } else {
                            $('.all_chk').prop('checked',false);
                        }
                    }
                })
            ;

            var checkParents = function (c)
            {
                var parentLi = c.parents('ul:eq(0)').parents('li:eq(0)').filter(function() {
                                    return !this.disabled;
                                });
                if (parentLi.length)
                {
                    var siblingsChecked = parseInt($('input[type="checkbox"]:checked', c.parents('ul:eq(0)'))
                            .filter(function() {
                                    return !this.disabled;
                                }).length);
                    var siblingsTotallength = parseInt($('input[type="checkbox"]', c.parents('ul:eq(0)'))
                            .filter(function() {
                                    return !this.disabled;
                                }).length);
                    rootCheckbox = parentLi.find('input[type="checkbox"]:eq(0)').filter(function() {
                                    return !this.disabled;
                                });
                    
                    

                    if (c.is(':checked')) 
                        rootCheckbox.prop('checked', true)
                    
                    else if (siblingsChecked === 0)
                        rootCheckbox.prop('checked', false);
                    else if(siblingsChecked != siblingsTotallength)
                        rootCheckbox.prop('checked', false);
                    
                    checkParents(rootCheckbox);
                }
            }

            var checkChildren = function (c)
            {
                var childLi = $('ul li input[type="checkbox"]', c.parents('li:eq(0)')).filter(function() {
                                    return !this.disabled;
                                });
                if (childLi.length) 
                    childLi.prop('checked', c.is(':checked'));
            }
        }

    });
})(jQuery);

