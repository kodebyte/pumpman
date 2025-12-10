<x-admin.app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">Rp 1.2M</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            +12.5%
                        </span>
                        <span class="text-gray-400 ml-2">from last month</span>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900">845</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            +5.2%
                        </span>
                        <span class="text-gray-400 ml-2">from last month</span>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-amber-50 text-amber-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Products</p>
                            <p class="text-2xl font-bold text-gray-900">128</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-red-500 flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                            -2.1%
                        </span>
                        <span class="text-gray-400 ml-2">new items added</span>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-50 text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Subscribers</p>
                            <p class="text-2xl font-bold text-gray-900">2,450</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            +18%
                        </span>
                        <span class="text-gray-400 ml-2">growth rate</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Sales Analytics (2025)</h3>
                        <select class="text-xs border-gray-300 rounded-md text-gray-500">
                            <option>Last 6 Months</option>
                            <option>Last Year</option>
                        </select>
                    </div>

                    <div class="flex items-end justify-between h-64 gap-2 pt-4 pb-2">
                        <div class="flex flex-col items-center w-full group">
                            <div class="w-full bg-indigo-100 rounded-t-md relative h-32 group-hover:bg-indigo-200 transition">
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition">Rp32M</div>
                            </div>
                            <span class="text-xs text-gray-500 mt-2">Jan</span>
                        </div>
                        <div class="flex flex-col items-center w-full group">
                            <div class="w-full bg-indigo-100 rounded-t-md relative h-44 group-hover:bg-indigo-200 transition">
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition">Rp44M</div>
                            </div>
                            <span class="text-xs text-gray-500 mt-2">Feb</span>
                        </div>
                        <div class="flex flex-col items-center w-full group">
                            <div class="w-full bg-indigo-100 rounded-t-md relative h-24 group-hover:bg-indigo-200 transition"></div>
                            <span class="text-xs text-gray-500 mt-2">Mar</span>
                        </div>
                        <div class="flex flex-col items-center w-full group">
                            <div class="w-full bg-indigo-100 rounded-t-md relative h-52 group-hover:bg-indigo-200 transition"></div>
                            <span class="text-xs text-gray-500 mt-2">Apr</span>
                        </div>
                        <div class="flex flex-col items-center w-full group">
                            <div class="w-full bg-indigo-100 rounded-t-md relative h-40 group-hover:bg-indigo-200 transition"></div>
                            <span class="text-xs text-gray-500 mt-2">May</span>
                        </div>
                        <div class="flex flex-col items-center w-full group">
                            <div class="w-full bg-indigo-600 rounded-t-md relative h-60 shadow-lg shadow-indigo-200">
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-indigo-800 text-white text-xs font-bold py-1 px-2 rounded">Rp60M</div>
                            </div>
                            <span class="text-xs font-bold text-indigo-700 mt-2">Jun</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Top Categories</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">Pumps & Motors</span>
                                <span class="text-gray-500">45%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">Electronics (AIWA)</span>
                                <span class="text-gray-500">32%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 32%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">Spare Parts</span>
                                <span class="text-gray-500">15%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-amber-400 h-2 rounded-full" style="width: 15%"></div>
                            </div>
                        </div>
                         <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">Accessories</span>
                                <span class="text-gray-500">8%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-gray-400 h-2 rounded-full" style="width: 8%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <button class="w-full py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">View Full Report</button>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Transactions</h3>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All Transactions &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Order ID</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">Amount</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">#ORD-00921</td>
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">AB</div>
                                    <span>Ahmad Budi</span>
                                </td>
                                <td class="px-6 py-4">Submersible Pump X200</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">Rp 4.500.000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Completed</span>
                                </td>
                                <td class="px-6 py-4 text-gray-400">2 mins ago</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">#ORD-00920</td>
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-xs">SC</div>
                                    <span>Siti Cahaya</span>
                                </td>
                                <td class="px-6 py-4">AIWA Speaker TWS</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">Rp 850.000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-gray-400">1 hour ago</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">#ORD-00919</td>
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">PT</div>
                                    <span>PT Maju Jaya</span>
                                </td>
                                <td class="px-6 py-4">Centrifugal Pump Heavy</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">Rp 12.000.000</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Processing</span>
                                </td>
                                <td class="px-6 py-4 text-gray-400">3 hours ago</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin.app-layout>