<script setup>
import SidenavItem from "./SidenavItem.vue";
import SidenavCollapse from "./SidenavCollapse.vue";

const navCollapses = [
  {
    ref: route('admin.dashboard'),
    text: 'Dashboard',
    route: 'admin.dashboard',
    icon: 'ni ni-atom',
    collapse: false,
    navItems: []
  },
  // {
  //   ref: 'admin',
  //   text: 'Admin',
  //   route: 'admin.admin.*',
  //   icon: 'ni ni-single-02',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'Admin List',
  //       route: 'admin.admin.index',
  //     }
  //   ]
  // },
  // {
  //   ref: 'trader',
  //   text: 'Trader',
  //   route: 'admin.trader.*',
  //   icon: 'ni ni-shop',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'Trader List',
  //       route: 'admin.trader.index',
  //     }
  //   ]
  // },
  // {
  //   ref: 'trades',
  //   text: 'Trades',
  //   route: 'admin.trade.*',
  //   icon: 'ni ni-single-02',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'Inject Trades',
  //       route: 'admin.trade.inject',
  //     }
  //   ]
  // },
  // {
  //   ref: 'user',
  //   text: 'User',
  //   route: 'admin.user.*',
  //   icon: 'ni ni-single-02',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'User List',
  //       route: 'admin.user.index',
  //     }
  //   ]
  // }
];

const othersNavCollapses = [
  // {
  //   ref: 'kyc',
  //   text: 'KYC',
  //   route: 'admin.kyc',
  //   icon: 'ni ni-image',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'KYC List',
  //       route: 'admin.kyc',
  //     }
  //   ]
  // },
  // {
  //   ref: 'affiliate',
  //   text: 'Affiliate',
  //   route: 'admin.affiliate.*',
  //   icon: 'ni ni-trophy',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'Affiliate',
  //       route: 'admin.affiliate',
  //     }
  //   ]
  // },
  // {
  //   ref: 'report',
  //   text: 'Report',
  //   route: 'admin.report.*',
  //   icon: 'ni ni-sound-wave',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'Report',
  //       route: 'admin.report',
  //     }
  //   ]
  // },
  // {
  //   ref: 'withdrawal',
  //   text: 'Withdrawal',
  //   route: 'admin.withdrawal.*',
  //   icon: 'ni ni-money-coins',
  //   collapse: true,
  //   navItems: [
  //     {
  //       text: 'Verification',
  //       route: 'admin.withdrawal.index',
  //     }
  //   ]
  // },
  {
    ref: 'setting',
    text: 'Settings',
    route: 'setting',
    icon: 'ni ni-align-left-2',
    collapse: true,
    navItems: [
      {
        text: 'Settings',
        route: 'admin.setting.edit',
      },
    ]
  }
];
</script>

<template>
  <div id="sidenav-collapse-main" class="collapse navbar-collapse w-auto h-auto h-100">
    <ul class="navbar-nav">
      <li class="nav-item">

        <sidenav-collapse :collapse="navCollapse.collapse" :collapse-ref="navCollapse.ref" :nav-text="navCollapse.text"
          :class="route().current(navCollapse.route) ? 'active' : ''" v-for="navCollapse in navCollapses"
          :key="navCollapse">
          <template #icon>
            <i class="text-primary text-sm opacity-10" :class="navCollapse.icon"></i>
          </template>
          <template #list>
            <ul class="nav ms-4">
              <!-- nav links -->
              <sidenav-item :href="route(navItem.route)" mini-icon="L" :text="navItem.text"
                v-for="navItem in navCollapse.navItems" :key="navItem" />
            </ul>
          </template>
        </sidenav-collapse>

      </li>

      <li class="mt-3 nav-item">
        <hr class="mt-0 horizontal dark" />
        <h6 class="text-xs ps-2 text-uppercase font-weight-bolder opacity-6">Others</h6>
      </li>
      <li class="nav-item">

        <sidenav-collapse :collapse="navCollapse.collapse" :collapse-ref="navCollapse.ref" :nav-text="navCollapse.text"
          :class="route().current(navCollapse.route) ? 'active' : ''" v-for="navCollapse in othersNavCollapses"
          :key="navCollapse">
          <template #icon>
            <i class="text-primary text-sm opacity-10" :class="navCollapse.icon"></i>
          </template>
          <template #list>
            <ul class="nav ms-4">
              <!-- nav links -->
              <sidenav-item :href="route(navItem.route)" mini-icon="L" :text="navItem.text"
                v-for="navItem in navCollapse.navItems" :key="navItem" />
            </ul>
          </template>
        </sidenav-collapse>

      </li>
    </ul>
  </div>
</template>
