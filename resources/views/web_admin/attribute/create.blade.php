@extends('web_admin.template.admin')                

<style type="text/css">
    
    .error
    {
        color: red;
    }
</style>

    @section('main_content')
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>

        </div>
    </div>
    <!-- END Page Title -->

    <!-- BEGIN Breadcrumb -->
    <div id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/').'/web_admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-text-width"></i>
                <a href="{{ url('/').'/web_admin/attribute/show/'.$enc_id}}">Attributes</a>
            </li>   
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active">  {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->





    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-text-width"></i>
                {{ isset($page_title)?$page_title:"" }}
            </h3>
            <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
            </div>
        </div>
        <div class="box-content">

          @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success') }}
            </div>
          @endif  

          @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('error') }}
            </div>
          @endif

          <form class="form-horizontal" 
                name="frm-attribute" 
                id="validation-form" 
                method="POST" 
                action="{{ url('/web_admin/attribute/store') }}"
                >


           {{ csrf_field() }}

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Child Category<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <select class="form-control" name="fk_category_id" id="fk_category_id" data-rule-required="true" readonly>
                        
                        @if(isset($arr_category) && sizeof($arr_category) > 0)
                            

                                <option value="{{$arr_category['cat_id']}}" selected>{{$arr_category['cat_slug']}}</option>

                            
                        @endif

                    </select>
                    
                    <span class='help-block'>{{ $errors->first('fk_category_id') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Attribute Code<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="attribute_code" id="attribute_code" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('attribute_code') }}</span>
                </div>
            </div>

            

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Frontend Input<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <select class="form-control" name="frontend_input" id="frontend_input" data-rule-required="true" >
                        <option value="">Select</option>
                        @if(isset($arr_front_end_inputs))
                            @foreach($arr_front_end_inputs as $key => $value)
                                <option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        @endif
                    </select>
                    
                    <span class='help-block'>{{ $errors->first('frontend_input') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Frontend Label<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">

                    <input class="form-control" name="frontend_label" id="frontend_label" data-rule-required="true" />                    

                    <span class='help-block'>{{ $errors->first('frontend_label') }}</span>
                </div>
            </div>
           

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Attribute Validationt<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <select class="form-control" name="fk_attribute_validation" id="fk_attribute_validation" data-rule-required="true" >
                        <option value="">Select</option>
                        @if(isset($arr_attributes_validations))
                            @foreach($arr_attributes_validations as $valide)
                                <option value="{{$valide['attr_validation_id']}}">{{$valide['attr_validation_name']}}</option>
                            @endforeach
                        @endif
                    </select>
                    
                    <span class='help-block'>{{ $errors->first('fk_attribute_validation') }}</span>
                </div>
            </div>
            

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Frontend Class</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="frontend_class" id="frontend_class"/>
                    <span class='help-block'>{{ $errors->first('frontend_class') }}</span>
                </div>
            </div>


            {{-- <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Default Value</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="default_value" id="default_value"/>
                    <span class='help-block'>{{ $errors->first('default_value') }}</span>
                </div>
            </div> --}}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Position</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="position" id="position"/>
                    <span class='help-block'>{{ $errors->first('position') }}</span>
                </div>
            </div>

            

            {{-- <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Range Min</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="range_min" id="range_min"/>
                    <span class='help-block'>{{ $errors->first('range_min') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Range Max</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="range_max" id="range_max"/>
                    <span class='help-block'>{{ $errors->first('range_max') }}</span>
                </div>
            </div> --}}


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"></label>
                <div class="col-sm-9 col-lg-10 controls">
                    <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_fillterable" id="is_fillterable">
                        Fillterable
                    </label>
                    {{-- <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_searchable" id="is_searchable">
                        Searchable
                    </label> --}}
                </div>
            </div>

            <div class="form-group" id="section_front_fitter_type">                
                <label class="col-sm-3 col-lg-2 control-label" for="name">Front Fitter Type</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <select class="form-control" name="front_fitter_type" id="front_fitter_type">
                        <option value="">Select</option>
                        @if(isset($arr_front_end_inputs))
                            @foreach($arr_front_end_inputs as $key => $value)
                                <option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        @endif
                    </select>                    
                    {{-- <input class="form-control" name="front_fitter_type" id="front_fitter_type"/> --}}
                    <span class='help-block'>{{ $errors->first('front_fitter_type') }}</span>
                    <div class="error" id="filter_type"></div>
                </div>
            </div>


            {{-- <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"></label>
                <div class="col-sm-9 col-lg-10 controls">
                    <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_global" id="is_global">
                        Global
                    </label>
                    <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_visible" id="is_visible">
                        Visible
                    </label>
                    
                </div>
            </div>
 --}}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"></label>
                <div class="col-sm-9 col-lg-10 controls">                    
                    <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_required" id="is_required">
                        Required
                    </label>
                   {{--  <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_user_define" id="is_user_define">
                        User Define
                    </label> --}}
                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"></label>
                <div class="col-sm-9 col-lg-10 controls">
                    <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_range" id="is_range">
                        Range
                    </label>
                    <label class="checkbox-inline col-sm-3 col-lg-2">
                        <input type="checkbox" value="1" name="is_advance_search" id="is_advance_search">
                        Advance Search
                    </label>
                    
                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Status</label>
                <div class="col-sm-9 col-lg-10 controls">
                    <label class="radio-inline col-sm-3 col-lg-2">
                        <input type="radio" checked="" value="1" name="is_active">
                        Active
                    </label>
                    <label class="radio-inline col-sm-3 col-lg-2">
                        <input type="radio" value="0" name="is_active">
                        Inactive
                    </label>
                </div>
            </div>

            <br/><br/>

            <div id="section_attribute_value">
                <div class="form-group" id="section_clone_attribute_value">
                    <label class="col-sm-2 col-lg-2 control-label" for="name">Attribute Value</label>
                    <div class="col-sm-3 col-lg-2 controls">
                        <input class="form-control" name="value[]"/>
                        <span class='help-block'>{{ $errors->first('value') }}</span>
                    </div>
                    <label class="col-sm-2 col-lg-1 control-label" for="name">Sort Order</label>
                    <div class="col-sm-2 col-lg-1 controls">
                        <input class="form-control" name="sort_order[]" />
                        <span class='help-block'>{{ $errors->first('sort_order') }}</span>
                    </div>
                    <div class="col-sm-2 col-lg-1 controls">
                        <input type="radio" value="1" name="is_default_selected[]" checked onclick="return set_default_value(this);">&nbsp;&nbsp;Default
                    </div> 
                    <div class="col-sm-2 col-md-2" style="float:left;">
                        <a id="add-attribute-value" href="javascript:void(0);" onclick="return add_attribute();">
                            <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></span>
                        </a>
                        <span style="margin-left:05px;">
                            <a id="remove-image" href="javascript:void(0);" onclick="return remove_attribute();">
                                <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
                            </a>
                        </span>
                    </div>                   
                </div>

            </div>
            <input class="form-control" type="hidden" name="default_index" id="default_index" value="0" />
            <div id="section_attribute_value_errors"></div>




            <div class="form-group">
                  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                    <input type="submit"  class="btn btn-primary" value="Create" onclick="return validate(event);">
                </div>
            </div>


    </form>
</div>
</div>
</div>
</div>

<script type="text/javascript">

    jQuery( document ).ready(function() 
    {
        var is_checked = jQuery("#is_fillterable").prop('checked');
        if(is_checked) 
        {
            jQuery("#section_front_fitter_type").show();            
        }
        else
        {
            jQuery("#section_front_fitter_type").hide();
        }

        jQuery("input[name='is_default_selected[]']:first").prop('checked', true);


        var front_inpute = jQuery("#frontend_input").val();

        if (front_inpute=="text") 
        {
            jQuery("#section_attribute_value").hide();
            // jQuery("#section_attribute_value :input").attr("disabled", true);
        }
        else
        {
            jQuery("#section_attribute_value").show();   
        }
    });


    jQuery("#is_fillterable").click(function () 
    {
        var is_checked = jQuery("#is_fillterable").prop('checked');

        if(is_checked) 
        {
            jQuery("#section_front_fitter_type").show();
            //jQuery("#front_fitter_type").attr("data-rule-required", "true");
        }
        else
        {
            jQuery("#section_front_fitter_type").hide();
            //jQuery("#front_fitter_type").attr("data-rule-required", "false");
             
        }

    });

    function validate(evn) 
    {
        evn.preventDefault();

        flag = validate_option_vlues();

        if (flag==0) 
        {
            return false;
        }

        var is_checked = jQuery("#is_fillterable").prop('checked');        
        if(is_checked) 
        {                        
            var filter_type = jQuery("#front_fitter_type").val();

            if(filter_type!="")
            {
                jQuery("#filter_type").empty();                
                jQuery("#validation-form").submit();
                return true;
                
            }
            else
            {
                jQuery("#filter_type").empty();
                jQuery("#filter_type").html("This field is required.");
                return false;
            }
        }
        else
        {
            jQuery("#filter_type").empty();
            jQuery("#validation-form").submit();
            return true;
        }
        //return true;
    }

    function validate_option_vlues(argument) 
    {
        flag = 1;


        var front_inpute = jQuery("#frontend_input").val();

        if (front_inpute=="text") 
        {
           flag = 1;
        }
        else
        {
            
        


            $('input[name^="value"]').each(function() {
                
                if ($(this).val()=="") 
                {
                    $('#section_attribute_value_errors').css('margin-left','230px');
                      $('#section_attribute_value_errors').css('color','red');
                      $('#section_attribute_value_errors').show();
                      $('#section_attribute_value_errors').fadeIn(3000);
                      document.getElementById('section_attribute_value_errors').innerHTML="Please fill all fields.";
                      setTimeout(function(){
                      $('#section_attribute_value_errors').fadeOut(4000);
                      },3000);
                    
                     flag=0;
                    // return flag;                 
                }
            });
            $('input[name^="sort_order"]').each(function() {
                
                if ($(this).val()=="") 
                {
                    $('#section_attribute_value_errors').css('margin-left','230px');
                      $('#section_attribute_value_errors').css('color','red');
                      $('#section_attribute_value_errors').show();
                      $('#section_attribute_value_errors').fadeIn(3000);
                      document.getElementById('section_attribute_value_errors').innerHTML="Please fill all fields.";
                      setTimeout(function(){
                      $('#section_attribute_value_errors').fadeOut(4000);
                      },3000);
                    
                     flag=0;
                     //return flag;
                }
                
            });

        }

        return flag;
    }

    function add_attribute() 
    {
            flag=1;

            var value = jQuery("input[name='value[]']:last").val();
            var sort_order = jQuery("input[name='sort_order[]']:last").val();
            var val_len = jQuery("input[name='value[]']").length;

            /*console.log(value);
            console.log(sort_order);
            return false;*/

            if(value == "" || sort_order == "")
            {
                  $('#section_attribute_value_errors').css('margin-left','230px');
                  $('#section_attribute_value_errors').css('color','red');
                  $('#section_attribute_value_errors').show();
                  $('#section_attribute_value_errors').fadeIn(3000);
                  document.getElementById('section_attribute_value_errors').innerHTML="This fildes are required.";
                  setTimeout(function(){
                  $('#section_attribute_value_errors').fadeOut(4000);
                  },3000);
                
                 flag=0;
                 return false;
            }


        //jQuery("#section_clone_attribute_value").clone().appendTo( "#section_attribute_value" );

        var value_html = "";
        value_html +=  '<div class="form-group" id="section_clone_attribute_value">';
        value_html += ' <label class="col-sm-2 col-lg-2 control-label" for="name">Attribute Value</label>';
        value_html += ' <div class="col-sm-3 col-lg-2 controls">';
        value_html += ' <input class="form-control" name="value[]" data-rule-required="true"/>';
        value_html += '</div>';
        value_html += '<label class="col-sm-2 col-lg-1 control-label" for="name">Sort Order</label>';
        value_html += '<div class="col-sm-2 col-lg-1 controls">';
        value_html += '<input class="form-control" name="sort_order[]" data-rule-required="true"/>';        
        value_html += '</div>';
        value_html += '<div class="col-sm-2 col-lg-1 controls">'
        value_html += '<input type="radio" value="1" name="is_default_selected[]" onclick="return set_default_value(this);">&nbsp;&nbsp;Default';
        value_html += '</div> ';
        value_html += '</div>';

        jQuery("#section_attribute_value").append(value_html);

    }

    function remove_attribute(ref) 
    {
        //jQuery(ref).parent('span').parent('div').parent('div').remove();
       

        var remove_val = jQuery("input[name='is_default_selected[]']:last");
        var remove_val_len = jQuery("input[name='is_default_selected[]']").length;

        if(remove_val.prop('checked'))
        {
            jQuery("input[name='is_default_selected[]']:first").prop('checked', true);
        }

      if(remove_val_len > 1){
        remove_val.parent().parent().remove();
      }
      
    }

    function set_default_value(ref) 
    {

        var selected_chk = $(ref).parent().parent().index();

        jQuery("#default_index").val(selected_chk);

    }
    


   jQuery("#frontend_input").change(function() 
   {
        var front_inpute = jQuery("#frontend_input").val();

        if (front_inpute=="text") 
        {
            jQuery("#section_attribute_value").hide();
            // jQuery("#section_attribute_value :input").attr("disabled", true);
        }
        else
        {
            jQuery("#section_attribute_value").show();   
        }

        return false;
   });


   
</script>

<!-- END Main Content -->


@stop                    