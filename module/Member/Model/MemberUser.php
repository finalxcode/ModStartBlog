<?php

namespace Module\Member\Model;

use Illuminate\Database\Eloquent\Model;

class MemberUser extends Model
{
    protected $table = 'member_user';
    
    protected $fillable = [
        'username', 'phone', 'email', 'password', 'status',
        'realname', 'area', 'expert_status', 'passwordSalt',
        'lastLoginTime', 'lastLoginIp', 'phoneVerified', 'emailVerified',
        'avatar', 'avatarMedium', 'avatarBig', 'gender', 'signature',
        'vipId', 'vipExpire', 'nickname', 'groupId', 'deleteAtTime',
        'isDeleted', 'messageCount', 'registerIp', 'registerIpName',
        'company_type', 'company_name', 'company_size', 'revenue',
        'company_description', 'contact_position', 'telephone',
        'zip_code', 'address', 'website'
    ];
}
