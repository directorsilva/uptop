<nav class="sidebar-nav">



    <ul id="sidebarnav">



        <li >

        	<a class="waves-effect waves-dark" href="{!! url('/dashboard') !!}">

        	 	<i class="mdi mdi-home"></i>

        	 	<span class="hide-menu">Dashboard</span>

        	</a>

        </li>



      

      <li>

        <a class="waves-effect waves-dark" href="{!! url('/rides') !!}" aria-expanded="false">

                <i class="mdi mdi-calendar-check"></i>

                <span class="hide-menu">{{trans('lang.all_rides')}}</span>

            </a>


        </li>

        

       

    </ul>

</nav>



<p class="webversion">V:<?php echo $app_setting->web_version; ?></p>

