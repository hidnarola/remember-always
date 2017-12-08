<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href=""><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row dashboard_layout">
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-body bg-teal-400 has-bg-image">
                <div class="media no-margin">
                    <div class="media-body">
                        <h3 class="no-margin"><?php echo $users; ?></h3>
                        <span class="text-uppercase text-size-mini">Active Users</span>
                    </div>
                    <div class="media-right media-middle">
                        <i class="icon-users2 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-body bg-pink-400 has-bg-image">
                <div class="media no-margin">
                    <div class="media-body">
                        <h3 class="no-margin"><?php echo $providers; ?></h3>
                        <span class="text-uppercase text-size-mini">Service Providers</span>
                    </div>
                    <div class="media-right media-middle">
                        <i class="icon-hammer-wrench icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-body bg-slate-400 has-bg-image">
                <div class="media no-margin">
                    <div class="media-body">
                        <h3 class="no-margin"><?php echo $profiles; ?></h3>
                        <span class="text-uppercase text-size-mini">Profiles</span>
                    </div>
                    <div class="media-right media-middle">
                        <i class="icon-profile icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-body bg-indigo-400 has-bg-image">
                <div class="media no-margin">
                    <div class="media-body">
                        <h3 class="no-margin"><?php echo $posts; ?></h3>
                        <span class="text-uppercase text-size-mini">Posts</span>
                    </div>
                    <div class="media-right media-middle">
                        <i class="icon-comment icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
