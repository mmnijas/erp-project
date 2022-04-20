@include('admin.layouts.navbar')
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('admin')}}" class="brand-link text-center">
      {{-- <img src="{{$settings->logo}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">ADMIN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/user2.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('change_password')}}" class="d-block">CHANGE PASSWORD</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
            
          <li class="nav-item">
            <a href="{{url('admin/settings')}}" id="settingsNav" class="nav-link">
                <i class="nav-icon fa fa-cog"></i>
                <p>SETTINGS</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="mastersNav"><i class="nav-icon fas fa-book"></i><p>MASTERS<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item"><a href="{{route('states.index')}}" id="statesNav" class="nav-link"><i class="far fa-circle nav-icon"></i><p>STATES</p></a></li>
              <li class="nav-item"><a href="{{route('districts.index')}}" id="districtsNav" class="nav-link"><i class="far fa-circle nav-icon"></i><p>DISTRICTS</p></a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="bankingNav"><i class="nav-icon fas fa-book"></i><p>BANKING<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item"><a href="{{route('bank-transactions.index')}}" id="bankTransactionsNav" class="nav-link">&emsp;<i class="far fa-circle nav-icon"></i><p>PAYMENTS</p></a></li>
              <li class="nav-item"><a href="{{route('customer-bank-accounts.index')}}" id="customerBankAccountsNav" class="nav-link">&emsp;<i class="far fa-circle nav-icon"></i><p>ACCOUNTS</p></a></li>
              <li class="nav-item"><a href="{{route('banks.index')}}" id="banksNav" class="nav-link">&emsp;<i class="far fa-circle nav-icon"></i><p>BANKS</p></a></li>
              <li class="nav-item"><a href="{{route('bank-service-commission-groups.index')}}" id="BankServiceCommissionGroupsNav" class="nav-link">&emsp;<i class="far fa-circle nav-icon"></i><p>COMMISSION GROUPS</p></a></li>
              <li class="nav-item"><a href="{{route('bank-service-charges.index')}}" id="bankServiceChargesNav" class="nav-link">&emsp;<i class="far fa-circle nav-icon"></i><p>SERVICE CHARGES</p></a></li>
              <li class="nav-item"><a href="{{route('banking-account-ledgers.index')}}" id="bankAccountLedgersNav" class="nav-link">&emsp;<i class="far fa-circle nav-icon"></i><p>LEDGERS</p></a></li>
              <li class="nav-item"><a href="{{route('banking-account-groups.index')}}" id="bankAccountGroupsNav" class="nav-link">&emsp;<i class="far fa-circle nav-icon"></i><p>GROUPS</p></a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="userManagementNav"><i class="nav-icon fas fa-book"></i><p>USER MANAGEMENT<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item"><a href="{{route('users.index')}}" id="usersNav" class="nav-link"><i class="far fa-circle nav-icon"></i><p>USERS</p></a></li>
              <li class="nav-item"><a href="{{route('roles.index')}}" id="rolesNav" class="nav-link"><i class="far fa-circle nav-icon"></i><p>ROLES</p></a></li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="javascript:void" class="nav-link" onclick="$('#logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>LOGOUT</p>
            </a>
          </li>
          
        </ul>
       
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>