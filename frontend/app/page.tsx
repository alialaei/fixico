"use client";

import Link from "next/link";
import { useFeatureFlags } from "@/hooks/feature-flags";
import { useReports, useDeleteReport } from "@/hooks/reports";
import { Button } from "@/components/ui/button";
import {
  Table,
  TableHeader,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
} from "@/components/ui/table";
import { Spinner } from "@/components/ui/spinner";
import { EyeIcon, EditIcon } from "lucide-react";
import { DeleteButton } from "@/components/delete-button";

export default function ReportsPage() {
  const {
    reports,
    isPending: reportsLoading,
    error: reportsError,
  } = useReports();

  const { mutateAsync: deleteReport, isPending: deleteReportLoading } =
    useDeleteReport();

  const {
    isActiveOnFlag,
    isPending: flagsLoading,
    error: flagsError,
  } = useFeatureFlags();

  if (reportsLoading || flagsLoading) {
    return (
      <div className="flex items-center justify-center py-12">
        <Spinner className="w-6 h-6 mr-2" />
      </div>
    );
  }

  if (reportsError || flagsError) {
    return (
      <div className="flex items-center justify-center py-12">
        <span className="text-red-600">Failed to load data.</span>
      </div>
    );
  }

  return (
    <main className="space-y-4">
      <header className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">Car Damage Reports</h1>

        {isActiveOnFlag("enable_report_creation") && (
          <Button asChild>
            <Link href="/reports/new">New report</Link>
          </Button>
        )}
      </header>

      <section>
        {!reports || reports.length === 0 ? (
          <p className="text-sm text-slate-500">No reports yet.</p>
        ) : (
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Title</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Description</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {reports?.map((report) => (
                <TableRow key={report.id}>
                  <TableCell className="font-medium">{report.title}</TableCell>
                  <TableCell>
                    <span className="text-xs uppercase tracking-wide text-slate-500">
                      {report.status}
                    </span>
                  </TableCell>
                  <TableCell>
                    {report.description ? (
                      <span className="text-sm text-slate-600 line-clamp-2">
                        {report.description}
                      </span>
                    ) : (
                      <span className="text-slate-400 italic">
                        No description
                      </span>
                    )}
                  </TableCell>
                  <TableCell>
                    {isActiveOnFlag("enable_report_viewing") && (
                      <Button variant="ghost" size="icon" asChild>
                        <Link href={`/reports/${report.id}`}>
                          <EyeIcon className="w-4 h-4" />
                        </Link>
                      </Button>
                    )}
                    {isActiveOnFlag("enable_report_editing") && (
                      <Button variant="ghost" size="icon">
                        <Link href={`/reports/${report.id}`}>
                          <EditIcon className="w-4 h-4" />
                        </Link>
                      </Button>
                    )}
                    {isActiveOnFlag("enable_report_deletion") && (
                      <DeleteButton
                        onDelete={async () => {
                          await deleteReport(report.id);
                        }}
                        isLoading={deleteReportLoading}
                      />
                    )}
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        )}
      </section>
    </main>
  );
}
