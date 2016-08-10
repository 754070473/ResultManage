<?php

return array(
    'navigation' => [
        '教学周期管理'=>['icon-desktop','Period'],
        '权限管理'=>['icon-lock','Greap'],
        '角色管理'=>['icon-edit','Role'],
        '管理员管理'=>['icon-list','User'],
        '成绩管理'=>['icon-list-alt','Grade'],
        '组建管理'=>['icon-calendar','Group'],
        '教学周期列表'=>['periodList',['periodList','periodPage'] ],
        '添加权限'=>['poweradd',['powerAdd'] ],
        '权限列表'=>['showpower',['showpower'] ],
        '管理员添加'=>['useradd',['useraddpro'] ],
        '管理员列表'=>['userList',['userList'] ],
        '添加角色'=>['roleadd',['roleins'] ],
        '角色列表'=>['rolelist',['rolelist'] ],
        '查看成绩'=>['show',['show'] ],
        '成绩审核'=>['examine',['examine'] ],
        '创建学院'=>['groupClaShow',['collShow'] ],
        '创建班级'=>['collShow',['groupClaShow'] ],
        '组员录入'=>['groupMan',['groupMan'] ],
        '成绩录入'=>['grade',['grade','import','grade_add']]
    ] ,
    'not_navigation' => [
        '新增教学周期' => [
            'periodAdd','periodInfo'
        ] ,
        '考试安排详情' => [
            'periodExam','periodExamInfo'
        ]
    ]
);