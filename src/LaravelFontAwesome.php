<?php

namespace FontIconSearch\LaravelFontAwesome;
class LaravelFontAwesome
{
    public function icons($version = null)
    {
        if (is_null($version)) {
            $version = config('laravel-fontawesome.default_version');
        }

        return include __DIR__.'/versions/v'.$version.'/icons.php';
    }

    public function icon($library,$icon, $options = [])
    {
        $options = $this->getOptions($options);
//        $classes = $this->buildIconClasses($icon, (isset($options['class']) ? $options['class'] : ''));
//        dd($classes);
//        $attributes = $this->buildAttributes($options, $classes);
        return $this->buildIcon($library,$icon,$options);
    }

    /**
     * Strip the default fa- prefix from the icon name if provider.
     *
     * @param $icon
     *
     * @return string
     */
    protected function getIcon($icon)
    {

        return 'fa-'.str_replace('fa-', '', $icon);
    }

    /**
     * Get the icon options. If no array is given cast the option to a
     * string and assume it is an extra class name.
     *
     * @param $options
     *
     * @return array
     */
    protected function getOptions($options)
    {
        if (!is_array($options)) {
            $options = [
                'class' => (string) $options,
            ];
        }
        return $options;
    }

    /**
     * Gets the list of class names to add to the icon element we are about to generate.
     *
     * @param $icon
     * @param $extraClasses
     *
     * @return string
     */
    protected function buildIconClasses($icon, $extraClasses)
    {
        return $extraClasses != '' ? $extraClasses : '';
//        return $this->getIcon($icon).($extraClasses != '' ? ' '.$extraClasses : '');
    }

    /**
     * Build the attribute list to add to the icon we are about to generate.
     *
     * @param $options
     * @param $classes
     *
     * @return string
     */
    protected function buildAttributes($options, $classes)
    {

        $attributes = [];
        $attributes[] = 'class="'.$classes.'"';

        unset($options['class']);

        if (is_array($options)) {
            foreach ($options as $attribute => $value) {
                $attributes[] = $this->createAttribute($attribute, $value);
            }
        }

        return (count($attributes) > 0) ? implode(' ', $attributes) : '';
    }

    /**
     * Build the attribute.
     *
     * @param $attribute
     * @param $value
     *
     * @return string
     */
    protected function createAttribute($attribute, $value)
    {
        return $attribute.'="'.$value.'" ';
    }

    /**
     * Build the icon with the correct attributes.
     *
     * @param $attributes
     *
     * @return string
     */
    protected function buildIcon($library,$icon,$attributes)
    {
        if (isset($attributes['class'])){
            $exClass  = $attributes['class'];
            unset($attributes['class']);
        }else{
            $exClass = '';
        }

        $attr = '';
        foreach ($attributes as $key => $attribute){
            $attr.= $this->createAttribute($key,$attribute);
        }
        switch ($library){
            case 'material':
                $s = '<i class="material-icons '.$exClass.'" '.$attr.'>'.$icon.'</i>';
                break;
            case 'font-awesome':
                $s = '<i class="fa fa-'.$icon.' '.$exClass.'" '.$attr.'></i>';
                break;
            case 'glyphicon':
                $s = '<i class="glyphicon glyphicon-'.$icon.' '.$exClass.'" '.$attr.'></i>';
                break;
            case 'ionicons':
                $s = '<i class="ionicons ion-'.$icon.' '.$exClass.'" '.$attr.'></i>';
                break;
        }


        return $s;
    }


}
