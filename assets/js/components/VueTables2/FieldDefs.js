export default [
    {
        name: '__sequence',
        title: '#',
        titleClass: 'center aligned',
        dataClass: 'right aligned'
    },
    {
        name: 'name',
        sortField: 'name'
    },
    {
        name: 'age',
        sortField: 'birthdate',
        dataClass: 'center aligned'
    },
    {
        name: 'email',
        sortField: 'email'
    },
    {
        name: 'birthdate',
        sortField: 'birthdate',
        titleClass: 'center aligned',
        dataClass: 'center aligned'
    },
    {
        name: 'nickname',
        sortField: 'nickname',
        callback: 'allcap'
    },
    {
        name: 'gender',
        sortField: 'gender',
        titleClass: 'center aligned',
        dataClass: 'center aligned',
        callback: 'genderLabel'
    },
    {
        name: 'salary',
        sortField: 'salary',
        titleClass: 'center aligned',
        dataClass: 'right aligned',
        // visible: false
    },
    {
        name: '__component:custom-actions',
        title: 'Actions',
        titleClass: 'center aligned',
        dataClass: 'center aligned'
    }
];