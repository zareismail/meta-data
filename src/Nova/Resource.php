<?php 

namespace Zareismail\MetaData\Nova;

use Laravel\Nova\Resource as NovaResource; 
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;      
use Laravel\Nova\Fields\Select;  
use Laravel\Nova\Fields\Number; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\BooleanGroup; 
use OwenMelbz\RadioField\RadioButton;
use Superlatif\NovaTagInput\Tags;   
use OptimistDigital\MultiselectField\Multiselect;
use Laravel\Nova\Nova;

abstract class Resource extends NovaResource
{ 
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\MetaData\\Metadata';

	/**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
    	"name"
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return[
            ID::make("ID")->sortable(),   

            RadioButton::make(__("Choice Method"), 'field')
	            ->options([
	                Boolean::class       => __("Checkbox"),
	                Text::class          => __("Via Text"),
	                Number::class        => __("Via Integer"),
	                Select::class        => __("Dropdown list"),
	                BooleanGroup::class  => __("Checkbox list"),
	                RadioButton::class   => __("Radio button"),
	                Multiselect::class   => __("MultiSelect"),
	            ]) 
	            ->toggle([ 
	            	Boolean::class=> ['options'],
	            	Text::class   => ['options'],
	            	Number::class => ['options'],
	            ])
	            ->default(Boolean::class), 

            Text::make(__("Field Name"), "name")
                ->required()
                ->rules("required"),   

            Tags::make(__("Selectable options"), 'options')
            	->required()
            	->rules(! $this->isSelectable($request->field) ? 'required' : [])
            	->help(__("Enter user-selectable values")),

            $this->when(static::relatableResources(), function() use ($request) { 
                return Multiselect::make(__('Restrict For'), 'resource')
                            ->options($this->resourceInformation())
                            ->fillUsing(function($request, $model, $attribute) {
                                $model->{$attribute} = (array) $request->get($attribute);
                            });
            }),
        ];
    } 

    public function isSelectable($field)
    {
    	return in_array($field, [Boolean::class, Text::class, Number::class]);
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
                    ->whereJsonLength('resource', 0)
                    ->orWhereJsonContains('resource', static::relatableResources());
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query)
                        ->whereJsonLength('resource', 0)
                        ->orWhereJsonContains('resource', static::relatableResources());
    }

    public function resourceInformation()
    {
        return  collect(static::relatableResources())->mapWithKeys(function($resource) {
                    return [$resource::uriKey() => $resource::label()];
                })->all();
    }

    public static function relatableResources() : array
    {
        return [];
    }
}
