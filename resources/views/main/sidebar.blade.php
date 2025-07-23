<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Users -->
            <li class="has-arrow">
                <a href="#" aria-expanded="false">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <span class="nav-text">Users</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('users.index') }}">All Users</a></li>
                    @can('create users')
                        <li><a href="{{ route('users.create') }}">Add New User</a></li>
                    @endcan
                </ul>
            </li>

            <!-- My Payments (User Panel) -->
            <li class="{{ request()->routeIs('my.payments*') ? 'active' : '' }}">
                <a href="{{ route('my.payments.index') }}">
                    <i class="mdi mdi-wallet"></i>
                    <span class="nav-text">My Payments</span>
                </a>
            </li>


           @can('manage invoices')
                <li class="has-arrow">
                    <a href="#" aria-expanded="false">
                        <i class="mdi mdi-file-document"></i>
                        <span class="nav-text">Invoices</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('invoices.index') }}">All Invoices</a></li>
                        <li><a href="{{ route('invoices.create') }}">Generate Invoice</a></li>
                    </ul>
                </li>
            @endcan

           <!-- Payment Approval (Admin Only) -->
            @can('approve payments')
                <li>
                    <a href="{{ route('admin.payments.pending') }}">
                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                        <span class="nav-text">Payment Approvals</span>
                    </a>
                </li>
            @endcan

            <!-- Reports -->
            <li class="has-arrow">
                <a href="#" aria-expanded="false">
                    <i class="mdi mdi-chart-bar-stacked"></i>
                    <span class="nav-text">Reports</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('reports.user.payments.yearly') }}">Yearly User Payments</a></li>
                    <li><a href="{{ route('reports.user.payments.monthly') }}">Monthly Payment Summary</a></li>
                    <li><a href="{{ route('reports.invoices') }}">Invoice Report</a></li>
                </ul>
            </li>


            <!-- Bank Information -->
            <!-- Branch Information -->
            <li>
                <a href="{{ route('branches.index') }}">
                    <i class="mdi mdi-bank"></i>
                    <span class="nav-text">Branch Info</span>
                </a>
            </li>



            {{-- <!-- Subscriptions / Monthly Payment -->
            <li>
                <a href="{{ route('billing-cycles.index') }}">
                    <i class="mdi mdi-currency-usd"></i>
                    <span class="nav-text">Monthly Billing</span>
                </a>
            </li> --}}

            {{-- <!-- Support / Tickets -->
            <li>
                <a href="{{ route('tickets.index') }}">
                    <i class="mdi mdi-lifebuoy"></i>
                    <span class="nav-text">Support Tickets</span>
                </a>
            </li> --}}

            {{-- <!-- Admin Panel -->
            <li class="has-arrow">
                <a href="#" aria-expanded="false">
                    <i class="mdi mdi-shield-lock-outline"></i>
                    <span class="nav-text">Admin Panel</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.settings') }}">System Settings</a></li>
                    <li><a href="{{ route('admin.roles') }}">Manage Roles</a></li>
                    <li><a href="{{ route('admin.permissions') }}">Permissions</a></li>
                </ul>
            </li> --}}

            <!-- Backup -->
            @can('manage backups')
                <li>
                    <a href="{{ route('backup.index') }}">
                        <i class="mdi mdi-database-backup"></i>
                        <span class="nav-text">System Backup</span>
                    </a>
                </li>
            @endcan

        </ul>
    </div>
</div>
