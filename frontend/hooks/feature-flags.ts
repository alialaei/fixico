'use client';

import { useQuery } from '@tanstack/react-query';
import { FeatureFlagsMap, fetchFeatureFlags } from '../lib/api';

type UseFeatureFlagsOptions = {
  userId?: string;
  country?: string;
};

export function useFeatureFlags({ userId = '123', country = 'NL' }: UseFeatureFlagsOptions = {}) {

  const {
    data,
    isPending,
    error,
    ...rest
  } = useQuery<FeatureFlagsMap>({
    queryKey: ['featureFlags', userId, country],
    queryFn: () => fetchFeatureFlags(userId, country),
  });

  function isActiveOnFlag(key: string): boolean {
    return Boolean(data?.[key]);
  }

  return {
    flags: data || {},
    isPending,
    error,
    isActiveOnFlag,
    ...rest,
  };
}

