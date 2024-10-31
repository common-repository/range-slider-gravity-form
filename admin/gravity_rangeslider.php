<?php
class OC_GF_Field_Rangeslider extends GF_Field {

    public $type = 'Rangeslider';

    public function get_form_editor_field_title() { return esc_attr__( 'Rangeslider', 'gravityforms' ); }

    public function get_form_editor_button() {
        return array(
            'group' => 'advanced_fields',
            'text'  => $this->get_form_editor_field_title(),
            'onclick'   => "StartAddField('".$this->type."');",
        );
    }
    function get_form_editor_field_settings() {
        return array(
            'label_setting',
            'description_setting',
            'slider_range',
            'Prefixvalue',
            'slider_position',
            'stepvalue',
            'color',
            'tooltip_position',
            'slider_value_visibility',
            'label_placement_setting',
            'css_class_setting',
            'admin_label_setting',
            'default_value_setting',
            'visibility_setting',
            'prepopulate_field_setting',
            'conditional_logic_field_setting'           
        );
    }
    function is_conditional_logic_supported() { return true; }

    function get_value_submission( $field_values, $get_from_post=true ) {
            if(!$get_from_post) {
                    return $field_values;
            }
      return $get_from_post;
    } 
     function get_field_input( $form, $value = '', $entry = null ) {
        $is_entry_detail = $this->is_entry_detail();
        $is_form_editor  = $this->is_form_editor();
        $form_id  = $form['id'];
        $id       = intval( $this->id );
        $field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";
        $atts['type'] = 'hidden';
        $size          = $this->size;
        $disabled_text = $is_form_editor ? "disabled='disabled'" : '';
        $class_suffix  = $is_entry_detail ? '_admin' : '';
        $class         = $this->type . ' ' .$size . $class_suffix;
        $instruction = '';
        $read_only   = '';
        $atts['color'] = $this->color;
        $atts['Prefixvalue'] = $this->Prefixvalue;
        $atts['tooltip_position'] = $this->tooltip_position;
        $atts['min'] = $this->min;
        $atts['max'] = $this->max;
        $atts['slider_position'] = $this->slider_position;  
        $atts['stepvalue'] = $this->stepvalue;       

         return "<div class='ginput_container'><div class='slider-display'   sliderposition=".$atts['slider_position']."  step=".$atts['stepvalue']."  color=".$atts['color']."  prefix=".$atts['Prefixvalue']."  tooltipposition=".$atts['tooltip_position']."  min=".$atts['min']."  max=".$atts['max']." ><input  name='input_".$id."'  id=". $form_id." type=".$atts['type']."  /></div></div>"; 
     }
}
GF_Fields::register(new OC_GF_Field_Rangeslider() );


add_action( 'gform_field_standard_settings', 'OCRSGF_add_custom_field' , 10,  2);
function OCRSGF_add_custom_field( $position, $form_id )
 {      
         // retrieve the data earlier stored in the database or create it
         if ($position == 50) {
           ?> 
           <li class="slider_range field_setting">
                <label for="slider_range" class="section_label">
                       <?php  echo esc_html( __( 'Range', 'gravityforms' ) );?>
                </label>
                 <?php  echo esc_html( __( 'min', 'gravityforms' ) );?>
                <input type="number" id="slider_range_min"  name="min" min="1" onchange="SetFieldProperty('min', this.value);" /></br>
                 <?php  echo esc_html( __( 'max', 'gravityforms' ) );?>
                <input type="number" id="slider_range_max"  name="max" min="1"  onchange="SetFieldProperty('max', this.value);"/>
            </li>
            <li class="Prefixvalue field_setting">
                    <label for="Prefixvalue" class="section_label">
                            <?php  echo esc_html( __( 'Prefix', 'gravityforms' ) );?>
                    </label>
                    <input type="text" name="prefix" id="Prefixvalue"  onchange="SetFieldProperty('Prefixvalue', this.value);" />
            </li>
            <li class="slider_position field_setting">
                <label for="slider_position" class="section_label">
                       <?php  echo esc_html( __( 'prefix position', 'gravityforms' ) );?>
                </label>
               <?php  echo esc_html( __( 'Left', 'gravityforms' ) );?>
                <input type="radio" name="slider_position" value="left" onchange="SetFieldProperty('slider_position', this.value);" />
                <?php  echo esc_html( __( 'Right', 'gravityforms' ) );?>
                <input type="radio"   name="slider_position" value="right" onchange="SetFieldProperty('slider_position', this.value);"/>
            </li>
            <li class="stepvalue field_setting">
                    <label for="stepvalue" class="section_label">
                           <?php  echo esc_html( __( 'Step', 'gravityforms' ) );?>
                    </label>
                    <input type="number" id="stepvalue"  name="stepvalue" onchange="SetFieldProperty('stepvalue', this.value);"/>
            </li>
            <li class="color field_setting">
                    <label for="color" class="section_label">
                          <?php  echo esc_html( __( 'Color', 'gravityforms' ) );?>
                    </label>
                    <input type="color" id="color"  name="color" onchange="SetFieldProperty('color', this.value);"/>
            </li>
            <li class="tooltip_position field_setting">
                <label for="tooltip_position" class="section_label">
                       <?php  echo esc_html( __( 'tooltip position', 'gravityforms' ) );?>
                </label>
                  <?php  echo esc_html( __( 'Left', 'gravityforms' ) );?>
                <input type="radio"  name="tooltipposition" value="left"   onchange="SetFieldProperty('tooltip_position', this.value);"/>
                <?php  echo esc_html( __( 'Right', 'gravityforms' ) );?>
                <input type="radio"  name="tooltipposition" value="right"  onchange="SetFieldProperty('tooltip_position', this.value);"/>
                 <?php  echo esc_html( __( 'Top', 'gravityforms' ) );?>
                <input type="radio" name="tooltipposition" value="top"  onchange="SetFieldProperty('tooltip_position', this.value);" />
              <?php  echo esc_html( __( 'Bottom', 'gravityforms' ) );?>
                <input type="radio"  name="tooltipposition" value="bottom"  onchange="SetFieldProperty('tooltip_position', this.value);"/>
            </li>
    <?php 
    }      
}
add_action('gform_editor_js', 'OCRSGF_editor_script', 11, 2);
function OCRSGF_editor_script() {
  ?>
    <script type='text/javascript'>
    jQuery(document).ready(function($) {
        jQuery(document).bind("gform_load_field_settings", function(event, field, form){
             jQuery("#slider_range_min").val(field["min"]);
             jQuery("#slider_range_max").val(field["max"]);
             jQuery("#Prefixvalue").val(field["Prefixvalue"]);
             jQuery("input[name=slider_position][value=" + field["slider_position"] + "]").prop('checked', true);
             jQuery("#stepvalue").val(field["stepvalue"]);
             jQuery("#color").val(field["color"]);
             jQuery("input[name=tooltipposition][value=" + field["tooltip_position"] + "]").prop('checked', true);
        });
    });
   </script>

 <?php
}

