import { UserManager } from '@/app/model/user/manager'
import { AUTH_TOKEN } from '@/config/constants'
import useStorage from '@/hooks/useStorage'
import React, { useCallback, useEffect, useMemo, useState } from 'react'
import { User } from '@/types/model/user'
import AuthContext from './AuthContext'

export type AuthProviderProps = React.PropsWithChildren

const AuthProvider: React.FC<AuthProviderProps> = ({ children }): JSX.Element => {
  const [user, setUser] = useState<UserManager<User>>(() => new UserManager<User>(null))
  const storage = useStorage('local')

  /** TODO update logic for real fetch user */
  const [loading] = useState(false)
  const [error] = useState<Error | null>(null)
  const getUser = useCallback(() => {
    console.log('fetch some user')
  }, [])
  const logout = useCallback((): void => {
    storage.remove(AUTH_TOKEN)
    setUser(new UserManager<User>(null))
  }, [storage])

  useEffect(() => {
    if (!storage.has(AUTH_TOKEN)) {
      return
    }

    if (!user.isGuest()) {
      return
    }

    getUser()
  }, [getUser, user, storage])

  useEffect(() => {
    const listener = (e: StorageEvent) => {
      if (e.key === AUTH_TOKEN) {
        if (e.newValue !== null) {
          getUser()
        } else {
          setUser(new UserManager<User>(null))
        }
      }
    }
    window.addEventListener('storage', listener)
    return () => window.removeEventListener('storage', listener)
  }, [getUser])

  const context = useMemo(() => {
    return {
      user,
      getUser,
      logout,
      loading,
      error: error?.message || null,
    }
  }, [loading, error, user, getUser, logout])

  return <AuthContext.Provider value={context}>{children}</AuthContext.Provider>
}

export default AuthProvider
