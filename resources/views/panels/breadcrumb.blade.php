<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">@yield('title')</h2>
            </div>
            <br><br><br>
            <div class="col-12">
                <div id="alertError" class="alert alert-danger" role="alert"
                    style="display:none;{{ session()->get('locale') == 'en' ? 'text-align:left;' : 'text-align:right;' }}">
                    <h4 class="alert-heading">فشل الطلب</h4>
                    <div class="alert-body">
                        <div id="errorMessage"></div>
                        <ul id="listError"></ul>
                    </div>
                </div>

                <div id="alertSuccess" class="alert alert-success" role="alert"
                    style="display:none;{{ session()->get('locale') == 'en' ? 'text-align:left;' : 'text-align:right;' }}">
                    <h4 class="alert-heading">نجح الطلب</h4>
                    <div class="alert-body">
                        <div id="successMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
