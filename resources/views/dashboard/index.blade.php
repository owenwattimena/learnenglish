@extends('templates.index')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        Dashboard
                    </h1>
                    <div class="page-header-subtitle">Example dashboard overview and content summary</div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
    <div class="row">
        <div class="col-xl-4 mb-4">
            <!-- Dashboard example card 1-->
            <a class="card lift h-100" href="#!">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <i class="feather-xl text-primary mb-3" data-feather="package"></i>
                            <h5>Powerful Components</h5>
                            <div class="text-muted small">To create informative visual elements on your pages</div>
                        </div>
                        <img src="assets/img/illustrations/browser-stats.svg" alt="..." style="width: 8rem" />
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 mb-4">
            <!-- Dashboard example card 2-->
            <a class="card lift h-100" href="#!">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <i class="feather-xl text-secondary mb-3" data-feather="book"></i>
                            <h5>Documentation</h5>
                            <div class="text-muted small">To keep you on track when working with our toolkit</div>
                        </div>
                        <img src="assets/img/illustrations/processing.svg" alt="..." style="width: 8rem" />
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 mb-4">
            <!-- Dashboard example card 3-->
            <a class="card lift h-100" href="#!">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <i class="feather-xl text-green mb-3" data-feather="layout"></i>
                            <h5>Pages &amp; Layouts</h5>
                            <div class="text-muted small">To help get you started when building your new UI</div>
                        </div>
                        <img src="assets/img/illustrations/windows.svg" alt="..." style="width: 8rem" />
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
