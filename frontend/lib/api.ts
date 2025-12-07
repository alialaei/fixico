const API_BASE =
  process.env.NEXT_PUBLIC_API_BASE_URL || 'http://localhost:8000';

export type FeatureFlagsMap = Record<string, boolean>;

export type Report = {
  id: number;
  title: string;
  description: string | null;
  status: 'open' | 'in_review' | 'closed';
  created_at?: string;
  updated_at?: string;
};

export async function fetchFeatureFlags(
  userId = '123',//Sample Data
  country = 'NL',//Sample Data
): Promise<FeatureFlagsMap> {
  const params = new URLSearchParams({ user_id: userId, country });
  const res = await fetch(`${API_BASE}/api/feature-flags?${params.toString()}`);

  if (!res.ok) {
    throw new Error('Failed to load feature flags');
  }

  return res.json();
}

export async function fetchReports(): Promise<Report[]> {
  const res = await fetch(`${API_BASE}/api/reports`);

  if (!res.ok) {
    throw new Error('Failed to load reports');
  }

  return res.json();
}

export async function fetchReport(id: string | number): Promise<Report> {
  const res = await fetch(`${API_BASE}/api/reports/${id}`);

  if (!res.ok) {
    throw new Error('Failed to load report');
  }

  return res.json();
}

export async function createReport(payload: {
  title: string;
  description?: string;
}) {
  const res = await fetch(`${API_BASE}/api/reports`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload),
  });

  if (!res.ok) {
    throw new Error('Failed to create report');
  }

  return res.json();
}

export async function updateReport(
  payload: {
    id: string | number;
    title: string;
    description?: string;
    status?: 'open' | 'in_review' | 'closed';
  },
) {
  const res = await fetch(`${API_BASE}/api/reports/${payload.id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload),
  });

  if (!res.ok) {
    throw new Error('Failed to update report');
  }

  return res.json();
}

export async function deleteReport(id: string | number) {
  const res = await fetch(`${API_BASE}/api/reports/${id}`, {
    method: 'DELETE',
  });

  if (!res.ok) {
    throw new Error('Failed to delete report');
  }

  return res;
}