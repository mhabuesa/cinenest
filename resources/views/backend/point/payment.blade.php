@extends('layouts.backend')
@section('content')
    <div class="row">

        <div class="col-lg-6 m-auto">
            <div class="card bg-dark">
                <div class="card-header bg_yellow text-center">
                    <h4 class="text-white">Users Points </h4>
                </div>
                <div class="card-body text-center p-3 table-responsive">
                    <table class="table table-bordered">
                        <tr class="">
                            <th class="text-white">SL</th>
                            <th class="text-white">Name</th>
                            <th class="text-white">Rate</th>
                            <th class="text-white">Point</th>
                            <th class="text-white">Action</th>
                        </tr>

                        @foreach ($points as $key=> $point )
                            <tr>
                                <td class="text-white">{{$key+1}}</td>
                                <td class="text-white">{{$point->user->name}}</td>
                                <td class="text-white">{{$point->rate}}</td>
                                <td class="text-white">{{$point->point}}</td>
                                <td class="text-white">
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_rate{{$point->id}}"> <i class="fa-solid fa-pencil" style="color: #ffff;"></i></a>
                                </td>
                            </tr>
                            <!-- Edit Category Modal -->
                            <div class="modal fade" id="edit_rate{{$point->id}}" tabindex="-1" aria-hidden="true" >
                                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3 class="mb-2">Update Rate</h3>
                                    </div>
                                    <form class="row g-3" action="{{route('rate.update',$point->id)}}" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <label class="form-label w-100 text-start" for="modalAddCard">rate</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCard" name="rate" class="form-control credit-card-mask" type="number" placeholder="Rate" aria-describedby="modalAddCard2" required value="{{$point->rate}}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-4">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                                            <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <!--/ Edit Category Modal -->

                        @endforeach

                    </table>
                </div>
                <div class="card-footer bg_yellow text-center py-3">
                    <p class="fs_1">A minimum of 100 coins can be withdrawn from your Point</p>
                </div>

            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>All Payout Request</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-capitalize">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Method</th>
                            <th>Point</th>
                            <th>Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                        @forelse ($requests as $key=> $request )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$request->user->name}}</td>
                            <td>{{$request->method}}</td>
                            <td>{{$request->point}}</td>
                            <td>{{$request->number}}</td>
                            <td><span class="btn btn-warning">Pending</span></td>
                            <td>
                                <button class="dt-button add-new btn btn-primary waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#user_{{$request->id}}">
                                    <i class="fa-solid fa-dollar-sign px-1"></i>Pay
                                </button>
                            </td>
                        </tr>

                        {{-- Payment Offcanvas --}}
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="user_{{$request->id}}" aria-labelledby="offcanvasAddUserLabel" aria-modal="true" role="dialog">
                            <div class="offcanvas-header">
                                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">User Payment</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100 d-flex align-items-center">
                                <form method="POST" action="{{route('pay', $request->id)}}">
                                    @csrf
                                    <div class="m-auto w-100">
                                        <div class="mb-3">
                                            <label class="form-label">Number</label>
                                            <input type="text" disabled class="form-control" name="number" placeholder="Number" value="{{$request->number}}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Method</label>
                                            <input type="text" disabled class="form-control text-capitalize" name="method" placeholder="Number" value="{{$request->method}}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="amount">Amount</label>
                                            @php
                                                $rate = App\Models\PaymentInfoModel::where('user_id',$request->user_id)->first()->rate
                                            @endphp
                                            <input type="number" disabled class="form-control text-capitalize" id="amount" name="amount" placeholder="Amount" value="{{$request->point * $rate}}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="last_digit">Last Digit</label>
                                            <input type="number" class="form-control text-capitalize" name="last_digit" id="last_digit" placeholder="4 Digit">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea name="note" id="note" cols="30" rows="3" class="form-control"></textarea>
                                        </div>


                                        <div class="mb-3 fv-plugins-icon-container">
                                            <img src="" alt="" id="blah" width="200">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light mt-3">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td></td>
                            <td colspan="5" class="text-center"><strong>Not available any Request</strong></td>
                            <td></td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>All Payout History</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-capitalize">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Number</th>
                            <th>Method</th>
                            <th>Last Digit</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Status</th>
                        </tr>

                        @forelse ($payoutHistories as $key=> $history )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$history->user->name}}</td>
                            <td>{{$history->amount}}</td>
                            <td>{{$history->pay_number}}</td>
                            <td>{{$history->pay_method}}</td>
                            <td>{{$history->last_digit}}</td>
                            <td>{{$history->created_at->format('d/M/Y')}}</td>
                            <td>{{$history->note}}</td>
                            <td>
                                <span class="btn btn-success">Payment Done</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td></td>
                            <td colspan="6" class="text-center"><strong>Not available any Payment History</strong></td>
                            <td></td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@if (session('success'))
<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "success",
    title: "{{session('success')}}"
    });
</script>
@endif

@if (session('error'))
<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "error",
    title: "{{session('error')}}"
    });
</script>
@endif

@endpush
