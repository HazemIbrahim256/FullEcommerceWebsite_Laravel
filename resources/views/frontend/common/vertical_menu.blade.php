@php
    $categories = App\Models\Category::orderBy('category_name_en','ASC')->get();
@endphp





<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
    <nav class="yamm megamenu-horizontal">
    <ul class="nav">
        @foreach($categories as $cat)
        <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon {{$cat->category_icon}}" aria-hidden="true"></i>
        @if (session()->get('language')=='arabic')
        {{$cat->category_name_ar}}
        @else
        {{$cat->category_name_en}}
        @endif
        </a>
        <ul class="dropdown-menu mega-menu">
            <li class="yamm-content">
            <div class="row">
                @php
                    $subcategories = App\Models\Subcategory::where('category_id',$cat->id)->orderBy('subcategory_name_en','ASC')->get();
                @endphp
                @foreach($subcategories as $subcat)
                <div class="col-sm-12 col-md-3">
                <a href="{{url('subcategory/product/'.$subcat->id.'/'.$subcat->subcategory_slug_en)}}"><h2 class="title">
                    @if (session()->get('language')=='arabic')
                    {{$subcat->subcategory_name_ar}}
                    @else
                    {{$subcat->subcategory_name_en}}
                    @endif
                </h2></a>
                @php
                    $subsubcategories = App\Models\SubSubcategory::where('subcategory_id',$subcat->id)->orderBy('subsubcategory_name_en','ASC')->get();
                @endphp
                @foreach($subsubcategories as $subsubcat)

                <ul class="links list-unstyled">
                    <li><a href="{{url('subsubcategory/product/'.$subsubcat->id.'/'.$subsubcat->subsubcategory_slug_en)}}">
                        @if (session()->get('language')=='arabic')
                        {{$subsubcat->subsubcategory_name_ar}}
                        @else
                        {{$subsubcat->subsubcategory_name_en}}
                        @endif
                    </a></li>
                </ul>
                @endforeach
                </div>
                @endforeach
                <!-- /.col -->
                
                <!-- /.col --> 
            </div>
            <!-- /.row --> 
            </li>
            <!-- /.yamm-content -->
        </ul>
        <!-- /.dropdown-menu --> 
        </li>
        @endforeach
        <!-- /.menu-item -->
        
        
        
        <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-paper-plane"></i>Kids and Babies</a> 
        <!-- /.dropdown-menu --> </li>
        <!-- /.menu-item -->
        
        <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-futbol-o"></i>Sports</a> 
        <!-- ================================== MEGAMENU VERTICAL ================================== --> 
        <!-- /.dropdown-menu --> 
        <!-- ================================== MEGAMENU VERTICAL ================================== --> </li>
        <!-- /.menu-item -->
        
        <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-envira"></i>Home and Garden</a> 
        <!-- /.dropdown-menu --> </li>
        <!-- /.menu-item -->
        
    </ul>
    <!-- /.nav --> 
    </nav>
    <!-- /.megamenu-horizontal --> 
</div>
<!-- /.side-menu --> 