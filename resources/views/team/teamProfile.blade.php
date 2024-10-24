<x-app-layout>
    <div class="container">
        <div class="row">
           <div class="col-lg-10">
				<div class="page-header mb-2 d-md-flex justify-content-between">
					<div class="w-75 mt-3">
						<h1 class="page-title pl-6" style="padding-left: 12%;font-size: 32px;">
							{{ ucfirst($team->user->name) }}
						</h1>
					</div>
				</div>
			</div>
     	</div>
		<div class="row">
           <div class="col-lg-10">
              	<div class="card" style="margin-left: 4rem">
					<div class="card mb-4">
						<div class="border-bottom-0 btn btn-primary">
							<h3 class="card-title" style="align-content: center">
								 <a href="{{ route('profileedit', array('user_id' => $team->user->id,'team_id' => $team->id)) }}"
									class="btn btn-sm float-right" style="float: right!important; color:#fff;padding-top: 15px;">Edit Profile</a>
								<h4 style="float:left; color:white;margin-bottom: 1rem;">Colleague Profile</h4>
							</h3>
						</div>
						<table class="table mb-0">
							<tbody>
								<tr>
									<th width="200">Job Role</th>
									<td>{{ ucfirst($team->user->learningRole->name ?? '') }}</td>
								</tr>

								<tr>
									<th>Coach Access</th>
									<td>
										<div class="d-flex justify-content-start align-items-center">
									<span class="text-muted"> {{($team->is_coach=='1') ? 'This colleague is currently a coach':'This colleague is currently not a coach'}}  </span>
									</div>
									</td>
								</tr>
								<tr>
									<th>Address</th>
									<td>
										{{ ($team->user->address) }}
									</td>
								</tr>
								<tr>
									<th>Phone</th>
									<td><span class="text-muted">{{ ($team->user->phone) }}</span></td>
								</tr>
								<tr>
									<th>Email</th>
									<td>{{ ($team->user->email) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="card mb-4">
						<div class="btn btn-primary text-start" >
							<h4 class="card-title" style=" color:white;margin-top: 10px;">Unassign user from this practice</h4>
						</div>
						<div class="card-body text-muted">
							<div>
								<p>When a user is unassigned from a practice, the following will happen:</p>
								<ul>
									<li>The user will no longer show on your staff list</li>
									<li>Courses that the user has not yet started will be removed</li>
									<li>Partially complete and complete courses will remain available to the user.</li>
								</ul>
								<button type="button" class="btn btn-sm btn-light float-right" id="confirmAssignReassignToTeam" @if(empty($team->deleted_at)) value="unassign" @else value="assign" @endif onclick="confrmAssignUserToTeam(this,{{$team->id}})">
								@if(empty($team->deleted_at)) Unassign User @else Reassign User @endif
								</button>
							</div>
						</div>
					</div>
					<div class="modal fade"  id="delete_user"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="padding-top: 120px;">
					<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">Unassign User</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
						Are you sure you want to unassign this user from team?
						</div>
						<input type="hidden" id="team_id" >
						<input type="hidden" id="status" >
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button class="btn btn-primary" onclick="assignOrReassignUserToTeam()">Submit</button>

						</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		//href="{{url('team/user/restore/'.$team->id)}}"
		function toogle_add_colleague(){
			$('#inviteForm').toggle();
		}
	</script>
</x-app-layout>


