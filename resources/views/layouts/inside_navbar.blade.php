<div class="container">
    <div class="card bg-light">
        <div class="card-header">
            <div class="card-title">
                <i class="bi bi-list"></i>&nbsp;Menu list
            </div>
        </div>
        <div class="card-body row">
            <div class="col-md-2">
                <a href="{{ route('users.index') }}" style="text-decoration: none !important;">
                    <div class="card text-white bg-info zoom">
                        <div class="card-body text-center">
                            <h5>Users</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('users.trashed') }}" style="text-decoration: none !important;">
                    <div class="card text-white bg-info zoom">
                        <div class="card-body text-center">
                            <h5>Archived Users</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
