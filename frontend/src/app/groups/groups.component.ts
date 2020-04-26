import { Component, OnInit } from '@angular/core';
import { GroupService } from '../_services/group.service';

@Component({
  selector: 'app-groups',
  templateUrl: './groups.component.html',
  styleUrls: ['./groups.component.scss']
})
export class GroupsComponent implements OnInit {

  groups: any;

  constructor(
    private groupService: GroupService
  ) { }

  ngOnInit() {
    this.groupService.findAll().then(
      response => {
        this.groups = response;
        console.log(response)
      }
    )
  }

}
