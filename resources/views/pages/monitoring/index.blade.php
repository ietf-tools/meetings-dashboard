<x-base-layout>
    @section('styles')
    <style>
        .CellWithComment{
            position:relative;
        }
        .CellComment{
            display:none;
            position:absolute;
            z-index:100;
            border:1px;
            background-color:white;
            border-style:groove;
            border-width:1px;
            border-color:black;
            padding:3px;
            color:black;
            top:20px;
            left:20px;
            width: 170px;
        }
        .CellWithComment:hover span.CellComment{
            display:block;
        }
    </style>
    @append
    <div class="row g-5">
        <div class="col-lg-3 col-xl-3 col-md-3 col-xxl-3 col-sm-12">
            <div class="card card-stretch-15 card-bordered mb-5">
                <div class="card-header flex-nowrap border-0 pt-9">
                    <h3 class="card-title m-0">
                        <div class="symbol symbol-45px w-45px bg-light me-5">
                            <img src="/media/icons/duotone/General/Lock.svg" alt="image" class="p-3">
                        </div>
                            OIDC Login Status
                    </h3>
                </div>
                <div class="card-body">
                    <div class="fs-2tx fw-bolder mb-3" id="oidcStatus"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-xxl-3 col-sm-12">
            <div class="card card-stretch-15 card-bordered mb-5">
                <div class="card-header flex-nowrap border-0 pt-9">
                    <h3 class="card-title m-0">
                        <div class="symbol symbol-45px w-45px bg-light me-5">
                            <img src="/media/icons/duotone/General/Lock.svg" alt="image" class="p-3">
                        </div>
                        DataTracker Status
                    </h3>
                </div>
                <div class="card-body d-flex flex-column px-9 pt-6 pb-8">
                    <div class="fs-2tx fw-bolder mb-3" id="dtStatus"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-xxl-3 col-sm-12">
            <div class="card card-stretch-15 card-bordered mb-5">
                <div class="card-header flex-nowrap border-0 pt-9">
                    <h3 class="card-title m-0">
                        <div class="symbol symbol-45px w-45px bg-light me-5">
                            <img src="/media/icons/duotone/Navigation/Angle-double-up.svg" alt="image" class="p-3">
                        </div>
                        Transmit Traffic
                    </h3>
                </div>
                <div class="card-body d-flex flex-column px-9 pt-6 pb-8">
                    <div class="fs-2tx fw-bolder mb-3" id="transmitTrafficTile"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-xxl-3 col-sm-12">
            <div class="card card-stretch-20 card-bordered mb-5">
                <div class="card-header flex-nowrap border-0 pt-9">
                    <h3 class="card-title m-0">
                        <div class="symbol symbol-45px w-45px bg-light me-5">
                            <img src="/media/icons/duotone/Navigation/Angle-double-down.svg" alt="image" class="p-3">
                        </div>
                        Recieve Traffic
                    </h3>
                </div>
                <div class="card-body d-flex flex-column px-9 pt-6 pb-8">
                    <div class="fs-2tx fw-bolder mb-3" id="receiveTrafficTile"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-5">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xxl-6 col-sm-8 mb-5">
            <div class="card card-stretch card-bordered mb-5">
                <div class="card-header">
                    <h4 class="card-title">Systems</h4>
                </div>
                <div class="card-body table-full-width table-hover">
                    <table class="table table-row-dashed table-row-gray-300 gy-7" id="systemsTable">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800">
                                <th class="text-right">System</th>
                                <th class="">Ping</th>
                                <th class="">CPU</th>
                                <th class="">Memory</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-6 col-md-6 col-xxl-6 col-sm-none">
            <div class="card card-stretch-50  card-bordered mb-5">
                <div class="card-header">
                    <h3 class="card-title m-0">
                        Server Bandwidth Chart
                    </h3>
                </div>
                <div class="card-body d-flex flex-column">
                    <iframe class="responsive-iframe" src="https://graphs.noc.ietf.org/d-solo/snwUjgZ7k/graphs-for-dashboard?orgId=1&refresh=30s&theme=light&panelId=2" height="100%" frameborder="0"></iframe>                </div>
            </div>
        </div>
    </div>
</div>
</div>
</x-base-layout>


