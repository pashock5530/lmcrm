<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">

        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ URL::to('') }}"><i class="fa fa-backward"></i> Go to frontend</a>
            </li>
            <li>
                <a href="{{url('admin/dashboard')}}">
                    <i class="fa fa-dashboard fa-fw"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{url('admin/characteristics')}}">
                    <i class="fa fa-list"></i> Сharacteristics
                </a>
            </li>
            <!--
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-bullhorn"></i> Articles
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav collapse">
                        <li>
                            <a href="{{url('admin/articlecategory')}}">
                                <i class="glyphicon glyphicon-list"></i>  Article categories
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/article')}}">
                                <i class="glyphicon glyphicon-bullhorn"></i> Articles
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-camera"></i> Photo items
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav collapse">
                        <li>
                            <a href="{{url('admin/photoalbum')}}">
                                <i class="glyphicon glyphicon-list"></i> Photo albums
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/photo')}}">
                                <i class="glyphicon glyphicon-camera"></i> Photo
                            </a>
                        </li>
                    </ul>
                </li>
                -->
            <li>
                <a href="{{url('admin/user')}}">
                    <i class="glyphicon glyphicon-user"></i> Users
                </a>
            </li>
            <li>
                <a href="{{ URL::to('auth/logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
            </li>
        </ul>
    </div>
</div>