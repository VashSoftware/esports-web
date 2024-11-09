import 'momentum-trail'

declare module 'momentum-trail' {
    export interface RouterGlobal {
        url: 'http://localhost'
        port: null
        defaults: []
        routes: {
            'sanctum.csrf-cookie': { uri: 'sanctum/csrf-cookie'; methods: ['GET', 'HEAD'] }
            'matches.index': { uri: 'matches'; methods: ['GET', 'HEAD'] }
            'matches.create': { uri: 'matches/create'; methods: ['GET', 'HEAD'] }
            'matches.store': { uri: 'matches'; methods: ['POST'] }
            'matches.show': { uri: 'matches/{match}'; methods: ['GET', 'HEAD']; parameters: ['match'] }
            'matches.edit': { uri: 'matches/{match}/edit'; methods: ['GET', 'HEAD']; parameters: ['match'] }
            'matches.update': { uri: 'matches/{match}'; methods: ['PUT', 'PATCH']; parameters: ['match'] }
            'matches.destroy': { uri: 'matches/{match}'; methods: ['DELETE']; parameters: ['match'] }
            'map_pools.index': { uri: 'map_pools'; methods: ['GET', 'HEAD'] }
            'map_pools.create': { uri: 'map_pools/create'; methods: ['GET', 'HEAD'] }
            'map_pools.store': { uri: 'map_pools'; methods: ['POST'] }
            'map_pools.show': { uri: 'map_pools/{map_pool}'; methods: ['GET', 'HEAD']; parameters: ['map_pool'] }
            'map_pools.edit': { uri: 'map_pools/{map_pool}/edit'; methods: ['GET', 'HEAD']; parameters: ['map_pool'] }
            'map_pools.update': { uri: 'map_pools/{map_pool}'; methods: ['PUT', 'PATCH']; parameters: ['map_pool'] }
            'map_pools.destroy': { uri: 'map_pools/{map_pool}'; methods: ['DELETE']; parameters: ['map_pool'] }
            'events.index': { uri: 'events'; methods: ['GET', 'HEAD'] }
            'events.create': { uri: 'events/create'; methods: ['GET', 'HEAD'] }
            'events.store': { uri: 'events'; methods: ['POST'] }
            'events.show': { uri: 'events/{event}'; methods: ['GET', 'HEAD']; parameters: ['event'] }
            'events.edit': { uri: 'events/{event}/edit'; methods: ['GET', 'HEAD']; parameters: ['event'] }
            'events.update': { uri: 'events/{event}'; methods: ['PUT', 'PATCH']; parameters: ['event'] }
            'events.destroy': { uri: 'events/{event}'; methods: ['DELETE']; parameters: ['event'] }
            'teams.index': { uri: 'teams'; methods: ['GET', 'HEAD'] }
            'teams.create': { uri: 'teams/create'; methods: ['GET', 'HEAD'] }
            'teams.store': { uri: 'teams'; methods: ['POST'] }
            'teams.show': { uri: 'teams/{team}'; methods: ['GET', 'HEAD']; parameters: ['team'] }
            'teams.edit': { uri: 'teams/{team}/edit'; methods: ['GET', 'HEAD']; parameters: ['team'] }
            'teams.update': { uri: 'teams/{team}'; methods: ['PUT', 'PATCH']; parameters: ['team'] }
            'teams.destroy': { uri: 'teams/{team}'; methods: ['DELETE']; parameters: ['team'] }
            'users.index': { uri: 'users'; methods: ['GET', 'HEAD'] }
            'users.create': { uri: 'users/create'; methods: ['GET', 'HEAD'] }
            'users.store': { uri: 'users'; methods: ['POST'] }
            'users.show': { uri: 'users/{user}'; methods: ['GET', 'HEAD']; parameters: ['user'] }
            'users.edit': { uri: 'users/{user}/edit'; methods: ['GET', 'HEAD']; parameters: ['user'] }
            'users.update': { uri: 'users/{user}'; methods: ['PUT', 'PATCH']; parameters: ['user'] }
            'users.destroy': { uri: 'users/{user}'; methods: ['DELETE']; parameters: ['user'] }
            'organizations.index': { uri: 'organizations'; methods: ['GET', 'HEAD'] }
            'organizations.create': { uri: 'organizations/create'; methods: ['GET', 'HEAD'] }
            'organizations.store': { uri: 'organizations'; methods: ['POST'] }
            'organizations.show': {
                uri: 'organizations/{organization}'
                methods: ['GET', 'HEAD']
                parameters: ['organization']
            }
            'organizations.edit': {
                uri: 'organizations/{organization}/edit'
                methods: ['GET', 'HEAD']
                parameters: ['organization']
            }
            'organizations.update': {
                uri: 'organizations/{organization}'
                methods: ['PUT', 'PATCH']
                parameters: ['organization']
            }
            'organizations.destroy': {
                uri: 'organizations/{organization}'
                methods: ['DELETE']
                parameters: ['organization']
            }
            'profile.edit': { uri: 'profile'; methods: ['GET', 'HEAD'] }
            'profile.update': { uri: 'profile'; methods: ['PATCH'] }
            'profile.destroy': { uri: 'profile'; methods: ['DELETE'] }
            register: { uri: 'register'; methods: ['GET', 'HEAD'] }
            login: { uri: 'login'; methods: ['GET', 'HEAD'] }
            'password.request': { uri: 'forgot-password'; methods: ['GET', 'HEAD'] }
            'password.email': { uri: 'forgot-password'; methods: ['POST'] }
            'password.reset': { uri: 'reset-password/{token}'; methods: ['GET', 'HEAD']; parameters: ['token'] }
            'password.store': { uri: 'reset-password'; methods: ['POST'] }
            'verification.notice': { uri: 'verify-email'; methods: ['GET', 'HEAD'] }
            'verification.verify': {
                uri: 'verify-email/{id}/{hash}'
                methods: ['GET', 'HEAD']
                parameters: ['id', 'hash']
            }
            'verification.send': { uri: 'email/verification-notification'; methods: ['POST'] }
            'password.confirm': { uri: 'confirm-password'; methods: ['GET', 'HEAD'] }
            'password.update': { uri: 'password'; methods: ['PUT'] }
            logout: { uri: 'logout'; methods: ['POST'] }
            'storage.local': {
                uri: 'storage/{path}'
                methods: ['GET', 'HEAD']
                wheres: { path: '.*' }
                parameters: ['path']
            }
        }
        wildcards: {
            'sanctum.*': []
            'matches.*': []
            'map_pools.*': []
            'events.*': []
            'teams.*': []
            'users.*': []
            'organizations.*': []
            'profile.*': []
            'password.*': []
            'verification.*': []
            'storage.*': []
        }
    }
}
